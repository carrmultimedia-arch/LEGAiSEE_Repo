<?php
/**
 * vault_module.php
 * LEGAiSEE — Report Vault Module
 *
 * Stores and retrieves generated reports against client/case records
 * Depends on: report_module.php (generates reports stored here)
 */

require_once __DIR__ . '/../db.php';
$db = $GLOBALS['pdo'];

// Handle report retrieval
if (isset($_GET['action']) && $_GET['action'] === 'download' && isset($_GET['report_path'])) {
    $report_path = $_GET['report_path'];
    $base_dir = realpath(__DIR__ . '/../data/clients');

    // Security check: ensure the path is within the allowed directory
    if (realpath($report_path) && strpos(realpath($report_path), $base_dir) === 0 && file_exists($report_path)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($report_path) . '"');
        header('Content-Length: ' . filesize($report_path));
        readfile($report_path);
        exit;
    } else {
        // Log this attempt if you have a logging system
        http_response_code(404);
        die('Report not found or access denied.');
    }
}

// Load clients and their reports
$clientsDir = __DIR__ . '/../data/clients';
$clientReports = [];

if (is_dir($clientsDir)) {
    foreach (glob($clientsDir . '/*', GLOB_ONLYDIR) as $clientDir) {
        $clientId = basename($clientDir);
        $clientMeta = [];
        
        // Load client profile
        $profileFile = $clientDir . '/profile.json';
        if (file_exists($profileFile)) {
            $clientMeta = json_decode(file_get_contents($profileFile), true);
        }
        
        // Load reports from cases
        $reports = [];
        foreach (glob($clientDir . '/cases/*/reports/*.pdf') as $reportFile) {
            $reports[] = [
                'filename' => basename($reportFile),
                'filepath' => $reportFile,
                'created_at' => date('Y-m-d H:i:s', filemtime($reportFile))
            ];
        }
        
        $clientReports[] = [
            'client_id' => $clientId,
            'client_name' => $clientMeta['name'] ?? $clientId,
            'reports' => $reports,
            'report_count' => count($reports)
        ];
    }
}

ob_start();
?>
<div class="vault-module">
    <h2>Report Vault</h2>
    
    <?php if (empty($clientReports)): ?>
        <p>No reports stored in the vault.</p>
    <?php else: ?>
        <?php foreach ($clientReports as $client): ?>
            <?php if ($client['report_count'] > 0): ?>
                <div class="vault-client">
                    <h3><?= htmlspecialchars($client['client_name']) ?> (<?= htmlspecialchars($client['client_id']) ?>)</h3>
                    <p><?= $client['report_count'] ?> report(s)</p>
                    
                    <div class="vault-reports">
                        <?php foreach ($client['reports'] as $report): ?>
                            <div class="vault-report">
                                <span class="vault-report__name"><?= htmlspecialchars($report['filename']) ?></span>
                                <span class="vault-report__date"><?= htmlspecialchars($report['created_at']) ?></span>
                                <a href="?module=vault&action=download&report_id=<?= urlencode($report['filename']) ?>" 
                                   class="vault-report__download">Download</a>
                                <button onclick="initiatePayment('<?= htmlspecialchars($client['client_id']) ?>', '<?= htmlspecialchars($client['client_name']) ?>', '<?= htmlspecialchars($report['filename']) ?>')"
                                   class="vault-report__pay">Request Payment</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
.vault-module { padding: 1rem; }
.vault-client { margin-bottom: 2rem; padding: 1rem; background: rgba(26,26,46,.5); border: 1px solid rgba(244,225,133,.12); border-radius: 8px; }
.vault-client h3 { margin: 0 0 0.5rem 0; color: #F4E185; }
.vault-client p { margin: 0 0 1rem 0; color: #888; }
.vault-reports { display: flex; flex-direction: column; gap: 0.5rem; }
.vault-report { display: flex; align-items: center; gap: 1rem; padding: 0.5rem; background: rgba(244,225,133,.05); border-radius: 4px; }
.vault-report__name { flex: 1; color: #e8e0cc; }
.vault-report__date { color: #666; font-size: 0.85rem; }
.vault-report__download { background: #89612B; color: #F4E185; border: none; padding: 0.3rem 0.8rem; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.85rem; }
.vault-report__download:hover { background: #CDAD69; color: #0a0a0c; }
.vault-report__pay { background: #2d5a27; color: #F4E185; border: none; padding: 0.3rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem; }
.vault-report__pay:hover { background: #4a7a42; color: #0a0a0c; }
</style>
<script>
function initiatePayment(clientId, clientName, reportId) {
    const tier = prompt('Select Exhibit tier:\n- shallow_dig ($500)\n- exhibit_a ($2,500)\n- exhibit_b ($5,000)\n- exhibit_c ($10,000)\n- exhibit_d ($25,000)\n- exhibit_e ($50,000)\n- exhibit_f ($100,000)\n- exhibit_g ($250,000)\n\nEnter tier name (e.g., shallow_dig):', 'shallow_dig');
    
    if (!tier) return;
    
    const clientEmail = prompt('Enter client email address:', '');
    if (!clientEmail) return;
    
    fetch('?module=payment&action=create_checkout', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            client_id: clientId,
            case_id: clientId.replace('client_', 'case_'),
            report_id: reportId,
            tier: tier,
            client_email: clientEmail
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            alert('Payment checkout session created. Redirecting to Stripe...');
            window.open(data.checkout_url, '_blank');
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>
<?php
return ob_get_clean();