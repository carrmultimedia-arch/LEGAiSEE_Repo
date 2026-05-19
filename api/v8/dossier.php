<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";

$data = json_decode(file_get_contents($file), true);

$nodes = $data['nodes'] ?? [];

$summary = [];
$signals = [];
$anomalies = [];

foreach ($nodes as $n) {

    if ($n['type'] === 'signal') $signals[] = $n;
    if ($n['type'] === 'anomaly') $anomalies[] = $n;

}

$report = [
    "overview" => "Network intelligence dossier",
    "signal_count" => count($signals),
    "anomaly_count" => count($anomalies),
    "top_signals" => array_slice($signals,0,5),
    "top_anomalies" => array_slice($anomalies,0,5)
];

echo json_encode($report, JSON_PRETTY_PRINT);