<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$patterns = [];

$anomalyCount = 0;
$signalCount = 0;

foreach ($nodes as $n) {
    if ($n['type'] === 'anomaly') $anomalyCount++;
    if ($n['type'] === 'signal') $signalCount++;
}

if ($anomalyCount > $signalCount) {
    $patterns[] = "Anomaly cluster forming";
}

if ($signalCount > 5) {
    $patterns[] = "High signal density (growth trend)";
}

echo json_encode([
    "patterns"=>$patterns
]);
echo json_encode($response);
exit;
