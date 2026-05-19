<?php
<?php
header('Content-Type: application/json');


$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$trend = 0;
$risk = 0;

foreach ($nodes as $n) {
    $trend += $n['strength'] ?? 0;

    if (($n['type'] ?? '') === 'anomaly') {
        $risk += $n['strength'];
    }
}

/* SIMPLE TIMELESS FORECAST MODEL */

$score = $trend - $risk;

if ($score > 200) {
    $forecast = "expansion trajectory";
} elseif ($score > 50) {
    $forecast = "stable growth";
} else {
    $forecast = "contraction / uncertainty";
}

echo json_encode([
    "network_id"=>$network_id,
    "forecast"=>$forecast,
    "score"=>$score
]);
echo json_encode($response);
exit;
