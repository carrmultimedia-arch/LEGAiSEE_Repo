<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$nodes = $data['nodes'] ?? [];

$signals = 0;
$anomalies = 0;
$total = 0;

foreach ($nodes as $n) {
    $total += $n['strength'] ?? 0;

    if (($n['type'] ?? '') === 'signal') $signals++;
    if (($n['type'] ?? '') === 'anomaly') $anomalies++;
}

$avg = count($nodes) ? $total / count($nodes) : 0;

$insights = [];

/* STRUCTURED INTERPRETATION */
if ($signals > $anomalies) {
    $insights[] = "System is signal-dominant (stable growth environment).";
} else {
    $insights[] = "System is anomaly-dominant (instability detected).";
}

if ($avg > 60) {
    $insights[] = "High-intensity information flow detected.";
} elseif ($avg < 20) {
    $insights[] = "Low signal density (inactive or early-stage network).";
}

echo json_encode([
    "network_id"=>$network_id,
    "insights"=>$insights,
    "signal_count"=>$signals,
    "anomaly_count"=>$anomalies,
    "avg_strength"=>$avg
]);
echo json_encode($response);
exit;
