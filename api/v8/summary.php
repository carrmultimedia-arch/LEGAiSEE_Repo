<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$nodes = $data['nodes'] ?? [];

$signals = 0;
$anomalies = 0;
$totalStrength = 0;

foreach ($nodes as $n) {
    if ($n['type'] === 'signal') $signals++;
    if ($n['type'] === 'anomaly') $anomalies++;
    $totalStrength += $n['strength'] ?? 0;
}

$summary = "Network contains {$signals} signals and {$anomalies} anomalies. ";

$summary .= ($anomalies > $signals)
    ? "Risk dominant environment detected. "
    : "Growth dominant environment detected. ";

$summary .= "Total strength score: {$totalStrength}.";

echo json_encode([
    "summary"=>$summary
]);
echo json_encode($response);
exit;
