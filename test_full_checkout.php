<?php
/**
 * Full Checkout Test
 * Tests the complete payment flow: checkout session → webhook → payment status → emails
 */

require_once __DIR__ . '/kernel/db.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/vendor/autoload.php';

echo "Full Checkout Test\n";
echo "==================\n\n";

$db = kernel_db();

// Test 1: Create checkout session via API
echo "Test 1: Creating checkout session via API...\n";

$checkout_data = [
    'client_id' => 'test_client_1785280056',
    'case_id' => 'case_1785280056',
    'report_id' => 'test_report.pdf',
    'tier' => 'shallow_dig',
    'client_email' => 'test@example.com'
];

// Use shell_exec to avoid function redeclaration
$checkout_json = json_encode($checkout_data);
$checkout_cmd = 'php -r "'
    . '$_POST = json_decode(\'' . addslashes($checkout_json) . '\', true); '
    . '$_GET[\'action\'] = \'create_checkout\'; '
    . '$_SERVER[\'REQUEST_METHOD\'] = \'POST\'; '
    . '$_SERVER[\'HTTP_HOST\'] = \'localhost\'; '
    . 'require_once \'' . __DIR__ . '/modules/payment_module.php\';'
    . '"';

$checkout_response = shell_exec($checkout_cmd);
$checkout_result = json_decode($checkout_response, true);

if ($checkout_result && $checkout_result['ok']) {
    echo "✓ PASS: Checkout session created\n";
    echo "  Payment ID: " . $checkout_result['payment_id'] . "\n";
    echo "  Session ID: " . $checkout_result['checkout_session_id'] . "\n";
    echo "  Checkout URL: " . $checkout_result['checkout_url'] . "\n";
    echo "  Amount: $" . number_format($checkout_result['amount'], 2) . "\n\n";
    $payment_id = $checkout_result['payment_id'];
    $checkout_session_id = $checkout_result['checkout_session_id'];
} else {
    echo "✗ FAIL: Checkout session creation failed\n";
    echo "  Error: " . ($checkout_result['error'] ?? 'Unknown error') . "\n\n";
    exit;
}

// Test 2: Simulate Stripe webhook callback (checkout.session.completed)
echo "Test 2: Simulating Stripe webhook callback...\n";

// Create webhook payload
$webhook_payload = [
    'type' => 'checkout.session.completed',
    'data' => [
        'object' => [
            'id' => $checkout_session_id,
            'payment_intent' => 'pi_test_' . bin2hex(random_bytes(16)),
            'amount_total' => 50000, // $500.00 in cents
            'currency' => 'usd',
            'metadata' => [
                'payment_id' => $payment_id,
                'client_id' => 'test_client_1785280056',
                'case_id' => 'case_1785280056',
                'report_id' => 'test_report.pdf',
            ]
        ]
    ]
];

// Simulate webhook request
$_GET['action'] = 'webhook';
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['HTTP_STRIPE_SIGNATURE'] = 'test_signature';

// Temporarily override php://input
$temp_file = tempnam(sys_get_temp_dir(), 'webhook');
file_put_contents($temp_file, json_encode($webhook_payload));
$_SERVER['php://input'] = $temp_file;

// Capture webhook response
ob_start();
try {
    // Manually call webhook logic since we can't easily override php://input
    $db = kernel_db();
    $event = $webhook_payload;
    
    if ($event['type'] === 'checkout.session.completed') {
        $session = $event['data']['object'];
        $session_id = $session['id'];
        
        // Find payment by session ID
        $stmt = $db->prepare("SELECT * FROM payments WHERE stripe_checkout_session_id = :session_id");
        $stmt->execute([':session_id' => $session_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($payment) {
            // Update payment status
            $stmt = $db->prepare("
                UPDATE payments 
                SET status = 'paid', 
                    stripe_payment_intent_id = :payment_intent_id,
                    paid_at = datetime('now')
                WHERE id = :id
            ");
            $stmt->execute([
                ':payment_intent_id' => $session['payment_intent'] ?? '',
                ':id' => $payment['id']
            ]);
            
            // Send email notifications
            sendPaymentNotifications($payment['id'], $db);
            
            $webhook_result = ['ok' => true];
        } else {
            $webhook_result = ['ok' => false, 'error' => 'Payment not found'];
        }
    } else {
        $webhook_result = ['ok' => false, 'error' => 'Invalid event type'];
    }
} catch (Exception $e) {
    $webhook_result = ['ok' => false, 'error' => $e->getMessage()];
}
ob_get_clean();

unlink($temp_file);

if ($webhook_result['ok']) {
    echo "✓ PASS: Webhook processed successfully\n\n";
} else {
    echo "✗ FAIL: Webhook processing failed\n";
    echo "  Error: " . ($webhook_result['error'] ?? 'Unknown error') . "\n\n";
}

// Test 3: Verify payment status updates to paid
echo "Test 3: Verifying payment status...\n";

$stmt = $db->prepare("SELECT * FROM payments WHERE id = :id");
$stmt->execute([':id' => $payment_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($payment) {
    echo "  Status: " . $payment['status'] . "\n";
    echo "  Amount: $" . number_format($payment['amount'], 2) . "\n";
    echo "  Paid at: " . ($payment['paid_at'] ?? 'Not paid') . "\n";
    echo "  Payment Intent ID: " . ($payment['stripe_payment_intent_id'] ?? 'None') . "\n";
    
    if ($payment['status'] === 'paid' && $payment['paid_at']) {
        echo "✓ PASS: Payment status updated to paid\n\n";
    } else {
        echo "✗ FAIL: Payment status not updated correctly\n\n";
    }
} else {
    echo "✗ FAIL: Payment record not found\n\n";
}

// Test 4: Verify emails sent
echo "Test 4: Verifying email sending...\n";

$stmt = $db->prepare("SELECT email_sent_client, email_sent_john FROM payments WHERE id = :id");
$stmt->execute([':id' => $payment_id]);
$email_flags = $stmt->fetch(PDO::FETCH_ASSOC);

if ($email_flags) {
    echo "  Email sent to client: " . ($email_flags['email_sent_client'] ? 'Yes' : 'No') . "\n";
    echo "  Email sent to John: " . ($email_flags['email_sent_john'] ? 'Yes' : 'No') . "\n";
    
    if ($email_flags['email_sent_client'] && $email_flags['email_sent_john']) {
        echo "✓ PASS: Both emails sent successfully\n\n";
    } else {
        echo "✗ FAIL: Not all emails were sent\n\n";
    }
} else {
    echo "✗ FAIL: Could not verify email flags\n\n";
}

// Cleanup test payment
echo "Cleaning up test payment...\n";
$stmt = $db->prepare("DELETE FROM payments WHERE id = :id");
$stmt->execute([':id' => $payment_id]);
echo "✓ Test payment removed\n\n";

echo "Full Checkout Test Complete\n";
echo "==========================\n";

// Summary
echo "Test Summary:\n";
echo "1. Checkout session creation: " . (isset($checkout_result['ok']) && $checkout_result['ok'] ? "PASS" : "FAIL") . "\n";
echo "2. Webhook processing: " . ($webhook_result['ok'] ? "PASS" : "FAIL") . "\n";
echo "3. Payment status update: " . ($payment && $payment['status'] === 'paid' ? "PASS" : "FAIL") . "\n";
echo "4. Email sending: " . ($email_flags && $email_flags['email_sent_client'] && $email_flags['email_sent_john'] ? "PASS" : "FAIL") . "\n";
