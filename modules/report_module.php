<?php
/**
 * report_module.php
 * LEGAiSEE — Report Generation Module
 *
 * Generates PDF reports from approved findings using dompdf
 * Depends on: dig_review_module.php (for approved findings)
 */

require_once __DIR__ . '/../kernel/kernel_boot.php';
require_once __DIR__ . '/../lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Handle PDF generation request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_report'])) {
    $case_id = $_POST['case_id'] ?? '';
    $client_id = $_POST['client_id'] ?? '';
    
    if (!$case_id || !$client_id) {
        die('Error: case_id and client_id required');
    }
    
    // Get approved findings from review_flags
    $approvedFindings = [];
    try {
        $stmt = kernel_db()->prepare("
            SELECT rf.source_table, rf.source_id, rf.context, rf.operator_note
            FROM review_flags rf
            WHERE rf.status = 'confirmed'
            AND rf.context = :client_id
        ");
        $stmt->execute([':client_id' => $client_id]);
        $approvedFindings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error loading approved findings: ' . $e->getMessage());
    }
    
    // Load case and client data from DB for accuracy
    $caseMeta = [];
    try {
        $caseStmt = kernel_db()->prepare("SELECT * FROM cases WHERE id = ?");
        $caseStmt->execute([$case_id]);
        $caseData = $caseStmt->fetch(PDO::FETCH_ASSOC);

        $clientStmt = kernel_db()->prepare("SELECT * FROM clients WHERE id = ?");
        $clientStmt->execute([$client_id]);
        $clientData = $clientStmt->fetch(PDO::FETCH_ASSOC);

        // Merge data, giving DB records precedence
        $caseMeta = [
            'id' => $caseData['id'] ?? $case_id,
            'name' => $caseData['name'] ?? 'Untitled Case',
            'client_id' => $clientData['id'] ?? $client_id,
            'client_name' => $clientData['name'] ?? 'Unknown Client',
            'created_at' => $caseData['created_at'] ?? date('Y-m-d'),
        ];
    } catch (Exception $e) {
        die('Error loading case/client DB records: ' . $e->getMessage());
    }
    
    // Generate HTML for PDF
    $html = generateReportHTML($caseMeta, $approvedFindings);
    
    // Generate PDF
    $options = new Options();
    $options->set('defaultFont', 'Times New Roman');
    $options->set('isHtml5ParserEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Output PDF
    $pdfContent = $dompdf->output();
    
    // Save to vault
    $vaultDir = __DIR__ . '/../data/clients/' . $client_id . '/cases/' . $case_id . '/reports';
    if (!is_dir($vaultDir)) {
        mkdir($vaultDir, 0755, true);
    }
    
    $reportFile = $vaultDir . '/report_' . time() . '.pdf';
    file_put_contents($reportFile, $pdfContent);
    
    // Download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="report_' . $case_id . '.pdf"');
    header('Content-Length: ' . strlen($pdfContent));
    echo $pdfContent;
    exit;
}

// Load cases for selection
$clientsDir = __DIR__ . '/../data/clients';
$cases = [];

if (is_dir($clientsDir)) {
    foreach (glob($clientsDir . '/*/cases/*/meta.json') as $metaFile) {
        $meta = json_decode(file_get_contents($metaFile), true);
        if ($meta) {
            $cases[] = $meta;
        }
    }
}

ob_start();
?>
<div class="report-module">
    <h2>Generate Report</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Select Case</label>
            <select name="case_id" required>
                <option value="">-- Select Case --</option>
                <?php foreach ($cases as $c): ?>
                    <option value="<?= htmlspecialchars($c['id'] ?? '') ?>" 
                            data-client="<?= htmlspecialchars($c['client_id'] ?? '') ?>">
                        <?= htmlspecialchars($c['name'] ?? $c['id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Client ID</label>
            <input type="text" name="client_id" id="client_id" required>
        </div>
        
        <button type="submit" name="generate_report" value="1">Generate PDF Report</button>
    </form>
</div>

<script>
document.querySelector('select[name="case_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('client_id').value = selectedOption.dataset.client || '';
});
</script>

<style>
.report-module { padding: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
.form-group select, .form-group input { 
    width: 100%; padding: 0.5rem; border: 1px solid #444; 
    background: #1a1a2e; color: #eee; border-radius: 4px; 
}
button { 
    background: #89612B; color: #F4E185; border: none; 
    padding: 0.6rem 1.2rem; border-radius: 6px; cursor: pointer; 
}
button:hover { background: #CDAD69; color: #0a0a0c; }
</style>
<?php
return ob_get_clean();

function generateReportHTML($caseMeta, $findings) {
    $caseName = $caseMeta['name'] ?? 'Untitled Case';
    $caseId = $caseMeta['id'] ?? '';
    $clientId = $caseMeta['client_id'] ?? '';
    $createdAt = $caseMeta['created_at'] ?? date('Y-m-d');
    
    $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LEGAiSEE Report - ' . htmlspecialchars($caseName) . '</title>
    <style>
        body { font-family: Times New Roman, serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #1a1a2e; }
        .meta { text-align: center; color: #666; margin-top: 10px; }
        .section { margin-bottom: 30px; }
        .section h2 { color: #89612B; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .finding { margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-left: 3px solid #89612B; }
        .finding strong { color: #1a1a2e; }
        .note { font-style: italic; color: #666; margin-top: 5px; }
        .footer { text-align: center; margin-top: 50px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LEGAiSEE Analysis Report</h1>
        <div class="meta">
            <p><strong>Case:</strong> ' . htmlspecialchars($caseName) . '</p>
            <p><strong>Case ID:</strong> ' . htmlspecialchars($caseId) . '</p>
            <p><strong>Client ID:</strong> ' . htmlspecialchars($clientId) . '</p>
            <p><strong>Generated:</strong> ' . date('Y-m-d H:i:s') . '</p>
        </div>
    </div>
    
    <div class="section">
        <h2>Approved Findings</h2>';
    
    if (empty($findings)) {
        $html .= '<p>No approved findings available for this report.</p>';
    } else {
        foreach ($findings as $finding) {
            $html .= '<div class="finding">
                <strong>' . htmlspecialchars($finding['source_table']) . '</strong> - ID: ' . htmlspecialchars($finding['source_id']);
            if ($finding['operator_note']) {
                $html .= '<div class="note">Note: ' . htmlspecialchars($finding['operator_note']) . '</div>';
            }
            $html .= '</div>';
        }
    }
    
    $html .= '</div>
    
    <div class="footer">
        <p>This report was generated by LEGAiSEE CommandCenter</p>
        <p>Confidential - For authorized use only</p>
    </div>
</body>
</html>';
    
    return $html;
}