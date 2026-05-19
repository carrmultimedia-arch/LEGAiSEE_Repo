<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$alerts = [];

foreach ($nodes as $n) {

    if ($n['type'] === 'anomaly' && $n['strength'] > 150) {
        $alerts[] = "High risk anomaly detected (".$n['id'].")";
    }

}

echo json_encode([
    "alerts"=>$alerts;
    echo json_encode($response);
exit;
