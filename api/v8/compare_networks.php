<?php
header('Content-Type: application/json');

$dir = __DIR__ . "/../../data/network/";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';
$files = glob($dir . "*.json");

$summary = [];

foreach ($files as $f) {

    $data = json_decode(file_get_contents($f), true);
    if (!$data) continue;

    $nodes = $data['nodes'] ?? [];

    $score = 0;
    $anomaly = 0;

    foreach ($nodes as $n) {
        $score += $n['strength'] ?? 0;
        if (($n['type'] ?? '') === 'anomaly') $anomaly++;
    }

    $summary[] = [
        "network_id"=>$data['id'] ?? basename($f),
        "node_count"=>count($nodes),
        "total_strength"=>$score,
        "anomalies"=>$anomaly
    ];
}

echo json_encode([
    "networks"=>$summary
]);
echo json_encode($response);
exit;