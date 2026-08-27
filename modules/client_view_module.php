<?php
declare(strict_types=1);

require_once __DIR__ . '/../kernel/kernel_boot.php';

function get_client_view_data(int $clientId): ?array
{
    $pdo = kernel_db();

    $client = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $client->execute([$clientId]);
    $client = $client->fetch(PDO::FETCH_ASSOC);
    if (!$client) return null;

    $case = $pdo->prepare("SELECT * FROM cases WHERE client_id = ? ORDER BY created_at DESC LIMIT 1");
    $case->execute([$clientId]);
    $case = $case->fetch(PDO::FETCH_ASSOC);

    // --- Fetch All Payments ---
    $payments_history = $pdo->prepare("SELECT * FROM payments WHERE client_id = ? ORDER BY created_at DESC");
    $payments_history->execute([$clientId]);
    $payments_history = $payments_history->fetchAll(PDO::FETCH_ASSOC);

    $payment = $pdo->prepare("SELECT * FROM payments WHERE client_id = ? ORDER BY created_at DESC LIMIT 1");
    $payment->execute([$clientId]);
    $payment = $payment->fetch(PDO::FETCH_ASSOC);

    $next_action = $pdo->prepare("SELECT * FROM processing_queue WHERE case_id = ? AND status = 'pending' ORDER BY id ASC LIMIT 1");
    $next_action->execute([$case['id'] ?? 0]);
    $next_action = $next_action->fetch(PDO::FETCH_ASSOC);

    // --- Fetch Approved Findings ---
    $findings = [];
    $stmt = $pdo->prepare("
        SELECT rf.id, rf.source_table, rf.source_id, rf.context
        FROM review_flags rf
        WHERE rf.status = 'confirmed' AND rf.context = :client_id
        ORDER BY rf.reviewed_at DESC
    ");
    $stmt->execute([':client_id' => $clientId]);
    $approved_flags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($approved_flags as $flag) {
        $finding_item = [
            'type' => 'Unknown',
            'label' => 'Details not found.',
            'summary' => 'Source ID: ' . $flag['source_id'],
        ];
        try {
            if ($flag['source_table'] === 'entities') {
                $row = $pdo->query("SELECT canonical_name, entity_type FROM entities WHERE id = {$flag['source_id']}")->fetch();
                if ($row) {
                    $finding_item['type'] = ucfirst($row['entity_type']);
                    $finding_item['label'] = $row['canonical_name'];
                    $finding_item['summary'] = "An entity of type '{$row['entity_type']}' has been identified and confirmed.";
                }
            } elseif ($flag['source_table'] === 'relationships') {
                $row = $pdo->query("
                    SELECT r.relation_type, e1.canonical_name AS entity_a, e2.canonical_name AS entity_b
                    FROM relationships r
                    LEFT JOIN entities e1 ON e1.id = r.from_entity
                    LEFT JOIN entities e2 ON e2.id = r.to_entity
                    WHERE r.id = {$flag['source_id']}
                ")->fetch();
                if ($row) {
                    $finding_item['type'] = 'Relationship';
                    $finding_item['label'] = "{$row['entity_a']} → {$row['entity_b']}";
                    $finding_item['summary'] = "A '{$row['relation_type']}' relationship has been confirmed between these entities.";
                }
            }
        } catch (Exception $e) { /* Ignore if source item is gone */ }
        $findings[] = $finding_item;
    }

    // --- Find Latest Report ---
    $report_file = null;
    if ($case) {
        $report_dir = __DIR__ . "/../data/clients/{$clientId}/cases/{$case['id']}/reports";
        if (is_dir($report_dir)) {
            $files = glob($report_dir . '/report_*.pdf');
            if ($files) {
                // Get the most recent report
                usort($files, fn($a, $b) => filemtime($b) <=> filemtime($a));
                $report_file = [
                    'path' => $files[0],
                    'name' => basename($files[0]),
                ];
            }
        }
    }

    $timeline = [];

    $case_events = $pdo->prepare("SELECT id, name, status, created_at FROM cases WHERE client_id = ?");
    $case_events->execute([$clientId]);
    foreach ($case_events->fetchAll(PDO::FETCH_ASSOC) as $e) {
        $timeline[] = [
            'ts' => $e['created_at'],
            'type' => 'Case Created',
            'label' => "Case '{$e['name']}' was created with status '{$e['status']}'.",
            'icon' => '📁',
        ];
    }

    $payment_events = $pdo->prepare("SELECT id, amount, status, created_at, paid_at FROM payments WHERE client_id = ?");
    $payment_events->execute([$clientId]);
    foreach ($payment_events->fetchAll(PDO::FETCH_ASSOC) as $e) {
        $timeline[] = [
            'ts' => $e['created_at'],
            'type' => 'Payment Initiated',
            'label' => "Payment of $" . number_format((float)$e['amount'], 2) . " initiated. Status: {$e['status']}.",
            'icon' => '💳',
        ];
        if ($e['paid_at']) {
            $timeline[] = [
                'ts' => $e['paid_at'],
                'type' => 'Payment Completed',
                'label' => "Payment of $" . number_format((float)$e['amount'], 2) . " was successfully paid.",
                'icon' => '✅',
            ];
        }
    }

    usort($timeline, fn($a, $b) => strtotime($b['ts']) <=> strtotime($a['ts']));

    return [
        'client' => $client,
        'case' => $case,
        'payment' => $payment,
        'next_action' => $next_action,
        'timeline' => $timeline,
        'findings' => $findings,
        'payments' => $payments_history,
        'report' => $report_file,
    ];
}

$clientId = (int)($_GET['id'] ?? 0);
if (!$clientId) {
    return "<div class='error'>No Client ID provided.</div>";
}

$data = get_client_view_data($clientId);
if (!$data) {
    return "<div class='error'>Client not found.</div>";
}

$activeTab = $_GET['tab'] ?? 'timeline';
?>

<style>
    .cv-header { padding: 1.5rem; background: rgba(10, 10, 12, 0.82); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; margin-bottom: 1.5rem; }
    .cv-client-name { font-size: 1.8rem; font-weight: 300; color: #F4E185; margin-bottom: 1rem; }
    .cv-stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
    .cv-stat-item { background: rgba(0,0,0,0.2); padding: 0.8rem 1rem; border-radius: 8px; }
    .cv-stat-label { font-size: 0.7rem; color: #89612B; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem; }
    .cv-stat-value { font-size: 0.95rem; color: #CDAD69; font-weight: 500; }
    .cv-payment-chip { display: inline-block; padding: .2rem .6rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; }
    .cv-payment-paid { background: #2d6a2d; color: #8fde8f; }
    .cv-payment-pending { background: #5a4010; color: #c8a040; }
    .cv-timeline { display: flex; flex-direction: column; gap: 1rem; }
    .cv-timeline-item { display: flex; gap: 1rem; align-items: flex-start; }
    .cv-timeline-icon { flex-shrink: 0; width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 1rem; }
    .cv-timeline-content { flex-grow: 1; padding-top: 0.3rem; }
    .cv-timeline-label { font-size: 0.9rem; color: #CDAD69; margin-bottom: 0.2rem; }
    .cv-timeline-meta { font-size: 0.75rem; color: #666; }
    .cv-findings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; }
    .cv-finding-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1rem; }
    .cv-finding-type { font-size: 0.7rem; color: #89612B; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .cv-finding-label { font-size: 1.1rem; color: #F4E185; font-weight: 400; margin-bottom: 0.5rem; }
    .cv-finding-summary { font-size: 0.85rem; color: #AC8B56; line-height: 1.6; }
    .cv-report-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 2rem; text-align: center; max-width: 400px; margin: 2rem auto; }
    .cv-report-icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .cv-report-title { font-size: 1.2rem; color: #F4E185; margin-bottom: 0.5rem; }
    .cv-report-meta { font-size: 0.8rem; color: #89612B; margin-bottom: 1.5rem; }
    .cv-payment-list { display: flex; flex-direction: column; gap: 1rem; }
    .cv-payment-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
    .cv-payment-details .amount { font-size: 1.5rem; color: #F4E185; font-weight: 300; }
    .cv-payment-details .meta { font-size: 0.8rem; color: #89612B; margin-top: 0.25rem; }
    .cv-payment-actions .status-chip { display: inline-block; padding: .3rem .8rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; }
    .cv-payment-actions .status-paid { background: #2d6a2d; color: #8fde8f; }
    .cv-payment-actions .status-pending { background: #5a4010; color: #c8a040; }
    .cv-payment-actions .btn-pay { margin-left: 1rem; }
</style>

<div class="cv-header">
    <h2 class="cv-client-name"><?= htmlspecialchars($data['client']['name']) ?></h2>
    <div class="cv-stat-grid">
        <div class="cv-stat-item">
            <div class="cv-stat-label">Pipeline Stage</div>
            <div class="cv-stat-value"><?= htmlspecialchars(ucfirst($data['case']['status'] ?? 'N/A')) ?></div>
        </div>
        <div class="cv-stat-item">
            <div class="cv-stat-label">Exhibit Tier</div>
            <div class="cv-stat-value"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $data['payment']['tier'] ?? 'N/A'))) ?></div>
        </div>
        <div class="cv-stat-item">
            <div class="cv-stat-label">Next Action</div>
            <div class="cv-stat-value"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $data['next_action']['task_type'] ?? 'None Queued'))) ?></div>
        </div>
        <div class="cv-stat-item">
            <div class="cv-stat-label">Payment Status</div>
            <div class="cv-stat-value">
                <?php $status = $data['payment']['status'] ?? 'unpaid'; $class = ($status === 'paid') ? 'cv-payment-paid' : 'cv-payment-pending'; ?>
                <span class="cv-payment-chip <?= $class ?>"><?= htmlspecialchars(ucfirst($status)) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="ui-tabs">
    <a href="?module=client_view&id=<?= $clientId ?>&tab=timeline" class="ui-tab-item <?= $activeTab === 'timeline' ? 'active' : '' ?>">Timeline</a>
    <a href="?module=client_view&id=<?= $clientId ?>&tab=graph" class="ui-tab-item <?= $activeTab === 'graph' ? 'active' : '' ?>">Graph</a>
    <a href="?module=client_view&id=<?= $clientId ?>&tab=findings" class="ui-tab-item <?= $activeTab === 'findings' ? 'active' : '' ?>">Findings</a>
    <a href="?module=client_view&id=<?= $clientId ?>&tab=report" class="ui-tab-item <?= $activeTab === 'report' ? 'active' : '' ?>">Report</a>
    <a href="?module=client_view&id=<?= $clientId ?>&tab=payment" class="ui-tab-item <?= $activeTab === 'payment' ? 'active' : '' ?>">Payment</a>
    <a href="?module=client_view&id=<?= $clientId ?>&tab=email" class="ui-tab-item <?= $activeTab === 'email' ? 'active' : '' ?>">Email</a>
</div>

<div class="ui-tab-content">
    <?php if ($activeTab === 'timeline'): ?>
        <div class="cv-timeline">
            <?php if (empty($data['timeline'])): ?>
                <div class="empty">No timeline events found for this client.</div>
            <?php else: ?>
                <?php foreach ($data['timeline'] as $event): ?>
                    <div class="cv-timeline-item">
                        <div class="cv-timeline-icon"><?= $event['icon'] ?></div>
                        <div class="cv-timeline-content">
                            <div class="cv-timeline-label"><?= htmlspecialchars($event['label']) ?></div>
                            <div class="cv-timeline-meta"><?= htmlspecialchars($event['type']) ?> &bull; <?= date('M j, Y, g:i a', strtotime($event['ts'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php elseif ($activeTab === 'graph'): ?>
        <?php if (!empty($data['case']['id'])): ?>
            <?php $_GET['case_id'] = $data['case']['id']; require __DIR__ . '/../graph_view.php'; ?>
        <?php else: ?>
            <div class="empty">No case associated with this client to generate a graph.</div>
        <?php endif; ?>
    <?php elseif ($activeTab === 'findings'): ?>
        <div class="cv-findings-grid">
            <?php if (empty($data['findings'])): ?>
                <div class="empty" style="grid-column: 1 / -1;">No findings have been approved for this client's case yet.</div>
            <?php else: ?>
                <?php foreach ($data['findings'] as $finding): ?>
                    <div class="cv-finding-card">
                        <div class="cv-finding-type"><?= htmlspecialchars($finding['type']) ?></div>
                        <div class="cv-finding-label"><?= htmlspecialchars($finding['label']) ?></div>
                        <div class="cv-finding-summary"><?= htmlspecialchars($finding['summary']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php elseif ($activeTab === 'report'): ?>
        <?php if ($data['report']): ?>
            <div class="cv-report-card">
                <div class="cv-report-icon">📄</div>
                <div class="cv-report-title">Analysis Report Ready</div>
                <div class="cv-report-meta">
                    <?= htmlspecialchars($data['report']['name']) ?><br>
                    Generated on <?= date('M j, Y', filemtime($data['report']['path'])) ?>
                </div>
                <a href="?module=vault&action=download&report_path=<?= urlencode($data['report']['path']) ?>" class="btn" download>Download PDF</a>
            </div>
        <?php else: ?>
            <div class="empty">
                No report has been generated for this client's case yet.
            </div>
        <?php endif; ?>
    <?php elseif ($activeTab === 'payment'): ?>
        <div class="cv-payment-list">
            <?php if (empty($data['payments'])): ?>
                <div class="empty">No payment on file for this client.</div>
            <?php else: ?>
                <?php foreach ($data['payments'] as $p): ?>
                    <div class="cv-payment-card">
                        <div class="cv-payment-details">
                            <div class="amount">$<?= number_format((float)$p['amount'], 2) ?></div>
                            <div class="meta">
                                Initiated on <?= date('M j, Y', strtotime($p['created_at'])) ?>
                                <?php if ($p['stripe_payment_intent_id']): ?>
                                    &bull; Ref: <?= htmlspecialchars(substr($p['stripe_payment_intent_id'], -8)) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cv-payment-actions">
                            <?php if ($p['status'] === 'paid'): ?>
                                <span class="status-chip status-paid">Paid on <?= date('M j, Y', strtotime($p['paid_at'])) ?></span>
                            <?php else: ?>
                                <span class="status-chip status-pending">Pending</span>
                                <button class="btn btn-pay" onclick="initiatePayment('<?= htmlspecialchars($data['client']['id']) ?>', '<?= htmlspecialchars($data['client']['name']) ?>', '<?= htmlspecialchars($p['id']) ?>', '<?= htmlspecialchars($p['amount']) ?>')">
                                    Generate Pay Link
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php elseif ($activeTab === 'email'): ?>
        <div class="empty">Email integration not yet connected.</div>
    <?php endif; ?>
</div>

<script>
function initiatePayment(clientId, clientName, paymentId, amount) {
    const clientEmail = prompt('Confirm client email address for receipt:', '');
    if (!clientEmail) return;

    // We can't know the original tier, so we pass the amount directly.
    // This requires a modification to the payment module.
    fetch('?module=payment&action=create_checkout_from_pending', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            payment_id: paymentId,
            client_email: clientEmail
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok && data.checkout_url) {
            alert('New payment link generated. Redirecting to Stripe...');
            window.open(data.checkout_url, '_blank');
        } else {
            alert('Error: ' + (data.error || 'Could not generate payment link.'));
        }
    })
    .catch(error => alert('Error: ' + error.message));
}
</script>