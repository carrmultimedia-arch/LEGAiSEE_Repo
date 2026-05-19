<?php

require_once __DIR__ . "/bootstrap.php";
require_once __DIR__ . "/lib/dompdf/autoload.inc.php";
require_once __DIR__ . '/lib/semantic_diff_engine.php';

use Dompdf\Dompdf;

/* --------------------------
   INPUT
--------------------------- */
$clusterId = $_GET['id'] ?? 0;

if (!$clusterId) {
    die("No cluster ID");
}

/* --------------------------
   LOAD DATA
--------------------------- */
$stmt = $pdo->prepare("
    SELECT name, summary, insights, opportunities
    FROM clusters
    WHERE id = ?
");
$stmt->execute([$clusterId]);

$cluster = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cluster) {
    die("Cluster not found");
}

$stmt = $pdo->prepare("
    SELECT title, platform, created
    FROM page
    WHERE cluster_id = ?
    ORDER BY created DESC
    LIMIT 20
");
$stmt->execute([$clusterId]);

$records = $stmt->fetchAll();

/* --------------------------
   BUILD HTML
--------------------------- */
$html = '
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #111;
}

h1 { font-size: 22px; margin-bottom: 10px; }
h2 { font-size: 16px; margin-top: 25px; }

.section {
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.record {
    margin-bottom: 8px;
    font-size: 11px;
}
</style>

<h1>' . htmlspecialchars($cluster['name'] ?: "Cluster Report") . '</h1>

<div class="section">
<h2>Executive Summary</h2>
' . nl2br(htmlspecialchars($cluster['summary'])) . '
</div>

<div class="section">
<h2>Key Insights</h2>
' . nl2br(htmlspecialchars($cluster['insights'])) . '
</div>

<div class="section">
<h2>Opportunities</h2>
' . nl2br(htmlspecialchars($cluster['opportunities'])) . '
</div>

<div class="section">
<h2>Supporting Records</h2>
';

foreach ($records as $r) {
    $html .= '<div class="record">'
        . htmlspecialchars($r['title']) . ' | '
        . htmlspecialchars($r['platform']) . ' | '
        . $r['created']
        . '</div>';
}

$html .= '</div>';

/* --------------------------
   GENERATE PDF
--------------------------- */
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

/* --------------------------
   OUTPUT
--------------------------- */
$filename = "cluster_report_" . $clusterId . ".pdf";

$dompdf->stream($filename, ["Attachment" => true]);