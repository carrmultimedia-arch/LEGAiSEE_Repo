<?php
header('Content-Type: application/json');

$network_id = $_GET['network_id'] ?? '';
if (!$network_id) {
    echo json_encode(["error"=>"missing network_id"]);
    exit;
}

$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

if (!file_exists($file)) {
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$total = 0;
$risk = 0;

foreach ($nodes as $n) {
    $total += $n['strength'] ?? 0;

    if (($n['type'] ?? '') === 'anomaly') {
        $risk += $n['strength'];
    }
}

/* STABLE MODEL */
$avg = count($nodes) ? $total / count($nodes) : 0;

if ($risk > 150) {
    $state = "high volatility";
} elseif ($avg > 50) {
    $state = "growth trend";
} else {
    $state = "stable";
}

echo json_encode([
    "network_id"=>$network_id,
    "state"=>$state,
    "avg_strength"=>$avg,
    "risk"=>$risk
]);
echo json_encode($response);
exit;
