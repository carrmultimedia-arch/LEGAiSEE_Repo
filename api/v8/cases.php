<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$anomalies = [];

foreach ($nodes as $n) {
    if (($n['type'] ?? '') === 'anomaly') {
        $anomalies[] = $n;
    }
}

$cases = [];

if (count($anomalies) > 3) {
    $cases[] = [
        "case_name" => "Anomaly Cluster Event",
        "severity" => "high",
        "description" => "Multiple anomaly nodes detected in system cluster."
    ];
}

if (count($nodes) > 10) {
    $cases[] = [
        "case_name" => "Data Saturation Event",
        "severity" => "medium",
        "description" => "Network approaching high-density state."
    ];
}

echo json_encode([
    "network_id"=>$network_id,
    "cases"=>$cases
]);
echo json_encode($response);
exit;