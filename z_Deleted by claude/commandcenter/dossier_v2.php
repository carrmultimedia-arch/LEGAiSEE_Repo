<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$signals = [];
$anomalies = [];

$total = 0;

foreach ($nodes as $n) {

    $total += $n['strength'] ?? 0;

    if (($n['type'] ?? '') === 'signal') {
        $signals[] = $n;
    }

    if (($n['type'] ?? '') === 'anomaly') {
        $anomalies[] = $n;
    }
}

$report = [
    "title" => "Intelligence Dossier",
    "network_id" => $network_id,
    "summary" => [
        "signal_count" => count($signals),
        "anomaly_count" => count($anomalies),
        "total_strength" => $total,
        "risk_ratio" => count($anomalies) / max(1,count($nodes))
    ],
    "top_signals" => array_slice($signals, 0, 5),
    "top_anomalies" => array_slice($anomalies, 0, 5)
];

echo json_encode($report, JSON_PRETTY_PRINT);