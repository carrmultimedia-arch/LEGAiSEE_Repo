<?php
/**
 * payment_module.php
 * LEGAiSEE — Payment Module
 *
 * Handles Stripe Checkout integration for Exhibit tiers
 * Triggers email notifications on successful payment
 */

require_once __DIR__ . '/../kernel/kernel_boot.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/vendor/autoload.php';

// Define Exhibit tier pricing
define('EXHIBIT_PRICING', [
    'shallow_dig' => 500.00,
    'exhibit_a' => 2500.00,
    'exhibit_b' => 5000.00,
    'exhibit_c' => 10000.00,
    'exhibit_d' => 25000.00,
    'exhibit_e' => 50000.00,
    'exhibit_f' => 100000.00,
    'exhibit_g' => 250000.00
]);

// Handle actions
$action = $_GET['action'] ?? 'status';

// Create Stripe Checkout Session
if ($action === 'create_checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $client_id = $input['client_id'] ?? '';
    $case_id = $input['case_id'] ?? '';
    $report_id = $input['report_id'] ?? '';
    $tier = $input['tier'] ?? 'shallow_dig';
    $client_email = $input['client_email'] ?? '';
    
    if (!$client_id || !$case_id || !$report_id || !$client_email) {
        echo json_encode(['ok' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    if (!isset(EXHIBIT_PRICING[$tier])) {
        echo json_encode(['ok' => false, 'error' => 'Invalid tier']);
        exit;
    }
    
    $amount = EXHIBIT_PRICING[$tier];
    
    try {
        // Create payment record
        $stmt = kernel_db()->prepare("
            INSERT INTO payments (client_id, case_id, report_id, amount, currency, status, payment_method)
            VALUES (:client_id, :case_id, :report_id, :amount, 'usd', 'pending', 'stripe_checkout')
        ");
        $stmt->execute([
            ':client_id' => $client_id,
            ':case_id' => $case_id,
            ':report_id' => $report_id,
            ':amount' => $amount
        ]);
        $payment_id = kernel_db()->lastInsertId();
        
        // Create Stripe Checkout Session using Stripe SDK
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'LEGAiSEE Report - ' . ucfirst(str_replace('_', ' ', $tier)),
                    ],
                    'unit_amount' => $amount * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/commandcenter/shell.php?module=payment&action=success&payment_id=' . $payment_id,
            'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/commandcenter/shell.php?module=payment&action=cancel&payment_id=' . $payment_id,
            'metadata' => [
                'payment_id' => $payment_id,
                'client_id' => $client_id,
                'case_id' => $case_id,
                'report_id' => $report_id,
            ],
        ]);
        
        // Update payment with session ID
        $update_stmt = kernel_db()->prepare("UPDATE payments SET stripe_checkout_session_id = :session_id WHERE id = :id");
        $update_stmt->execute([':session_id' => $checkout_session->id, ':id' => $payment_id]);
        
        echo json_encode([
            'ok' => true,
            'payment_id' => $payment_id,
            'checkout_session_id' => $checkout_session->id,
            'checkout_url' => $checkout_session->url,
            'amount' => $amount,
            'currency' => 'usd'
        ]);
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Create Stripe Checkout Session from an existing PENDING payment
if ($action === 'create_checkout_from_pending' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $payment_id = $input['payment_id'] ?? '';
    $client_email = $input['client_email'] ?? '';
    
    if (!$payment_id || !$client_email) {
        echo json_encode(['ok' => false, 'error' => 'Missing required fields']);
        exit;
    }

    try {
        // Find the pending payment
        $stmt = kernel_db()->prepare("SELECT * FROM payments WHERE id = :id AND status = 'pending'");
        $stmt->execute([':id' => $payment_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$payment) {
            echo json_encode(['ok' => false, 'error' => 'Pending payment not found or already paid.']);
            exit;
        }

        // Create a new Stripe Checkout Session for the existing payment record
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $payment['currency'] ?? 'usd',
                    'product_data' => [
                        'name' => 'LEGAiSEE Report Payment (ID: ' . $payment['id'] . ')',
                    ],
                    'unit_amount' => (int)((float)$payment['amount'] * 100), // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/commandcenter/shell.php?module=payment&action=success&payment_id=' . $payment_id,
            'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/commandcenter/shell.php?module=client_view&id=' . $payment['client_id'] . '&tab=payment',
            'metadata' => [ 'payment_id' => $payment_id, 'client_id' => $payment['client_id'], 'case_id' => $payment['case_id'] ],
        ]);
        
        // Update payment with the NEW session ID
        $update_stmt = kernel_db()->prepare("UPDATE payments SET stripe_checkout_session_id = :session_id WHERE id = :id");
        $update_stmt->execute([':session_id' => $checkout_session->id, ':id' => $payment_id]);
        
        echo json_encode(['ok' => true, 'checkout_url' => $checkout_session->url]);

    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle Stripe Webhook
if ($action === 'webhook' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
    
    try {
        // Verify webhook signature (in production)
        // $event = \Stripe\Webhook::constructEvent($payload, $sig_header, STRIPE_WEBHOOK_SECRET);
        
        // For testing, parse JSON directly
        $event = json_decode($payload, true);
        
        if (!$event) {
            echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
            exit;
        }
        
        if ($event['type'] === 'checkout.session.completed') {
            $session = $event['data']['object'];
            $session_id = $session['id'];
            
            // Find payment by session ID
            $stmt = kernel_db()->prepare("SELECT * FROM payments WHERE stripe_checkout_session_id = :session_id");
            $stmt->execute([':session_id' => $session_id]);
            $payment = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($payment) {
                // Update payment status
                $stmt = kernel_db()->prepare("
                    UPDATE payments 
                    SET status = 'paid', 
                        stripe_payment_intent_id = :payment_intent_id,
                        paid_at = CURRENT_TIMESTAMP
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':payment_intent_id' => $session['payment_intent'] ?? '',
                    ':id' => $payment['id']
                ]);
                
                // Send email notifications
                sendPaymentNotifications($payment);
            }
        }
        
        echo json_encode(['ok' => true]);
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Get payment status
if ($action === 'status' && isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    
    try {
        $stmt = kernel_db()->prepare("SELECT * FROM payments WHERE id = :id");
        $stmt->execute([':id' => $payment_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($payment) {
            echo json_encode(['ok' => true, 'payment' => $payment]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Payment not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Email notification function
function sendPaymentNotifications(array $payment): bool {
    $client_id = $payment['client_id'];
    $case_id = $payment['case_id'];
    $report_id = $payment['report_id'];
    $amount = $payment['amount'];
    
    // Get client email from profile
    $client_email = '';
    $profileFile = __DIR__ . "/../data/clients/{$client_id}/profile.json";
    if (file_exists($profileFile)) {
        $profile = json_decode(file_get_contents($profileFile), true);
        $client_email = $profile['email'] ?? '';
    }
    
    // Get client name
    $client_name = '';
    if (file_exists($profileFile)) {
        $profile = json_decode(file_get_contents($profileFile), true);
        $client_name = $profile['name'] ?? $client_id;
    }
    
    // Send email to client
    if ($client_email) {
        $subject = "Payment Confirmation - LEGAiSEE Report";
        $body = "Dear {$client_name},\n\n" .
                "Your payment of $" . number_format($amount, 2) . " has been successfully processed.\n\n" .
                "Your report is now available for download.\n" .
                "Case ID: {$case_id}\n" .
                "Report ID: {$report_id}\n\n" .
                "Thank you for your business.\n\n" .
                "LEGAiSEE CommandCenter";
        
        sendEmail($client_email, $subject, $body);
        
        // Mark client email as sent
        $update_stmt_client = kernel_db()->prepare("UPDATE payments SET email_sent_client = 1 WHERE id = :id");
        $update_stmt_client->execute([':id' => $payment['id']]);
    }
    
    // Send email to John
    $john_subject = "Payment Received - {$client_name}";
    $john_body = "Payment received from client:\n\n" .
                 "Client: {$client_name} ({$client_id})\n" .
                 "Case ID: {$case_id}\n" .
                 "Report ID: {$report_id}\n" .
                 "Amount: $" . number_format($amount, 2) . "\n" .
                 "Payment ID: {$payment['id']}\n\n" .
                 "Payment Status: Paid";
    
    sendEmail(JOHN_EMAIL, $john_subject, $john_body);
    
    // Mark John email as sent
    $update_stmt_john = kernel_db()->prepare("UPDATE payments SET email_sent_john = 1 WHERE id = :id");
    $update_stmt_john->execute([':id' => $payment['id']]);
    
    return true;
}

// Email sending function using PHPMailer with SMTP
function sendEmail(string $to, string $subject, string $body): bool {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;
        
        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}

// Default view - show payment status
ob_start();
?>
<div class="payment-module">
    <h2>Payment Module</h2>
    <p>Stripe Checkout integration for Exhibit tiers</p>
    
    <div class="payment-pricing">
        <h3>Exhibit Tier Pricing</h3>
        <ul>
            <?php foreach (EXHIBIT_PRICING as $tier => $price): ?>
                <li><?= ucfirst(str_replace('_', ' ', $tier)) ?>: $<?= number_format($price, 2) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<style>
.payment-module { padding: 1rem; }
.payment-pricing { margin-top: 1rem; padding: 1rem; background: rgba(26,26,46,.5); border: 1px solid rgba(244,225,133,.12); border-radius: 8px; }
.payment-pricing h3 { margin: 0 0 0.5rem 0; color: #F4E185; }
.payment-pricing ul { margin: 0; padding-left: 1.5rem; color: #e8e0cc; }
.payment-pricing li { margin-bottom: 0.25rem; }
</style>
<?php
return ob_get_clean();
