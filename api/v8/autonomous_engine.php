<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$path = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

if (!file_exists($path)) {
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($path), true);
$nodes = $network['nodes'] ?? [];

/* LOAD LEARNING MODEL */
$learningFile = __DIR__ . "/../../data/learning.json";
$learning = file_exists($learningFile)
    ? json_decode(file_get_contents($learningFile), true)
    : [];

$total = 0;
$risk = 0;
$signals = 0;

foreach ($nodes as $n) {

    $content = strtolower($n['content'] ?? '');

    $boost = 0;

    foreach ($learning as $l) {
        if (strpos($content, strtolower($l['pattern'])) !== false) {
            $boost += $l['weight'];
        }
    }

    $strength = ($n['strength'] ?? 0) + ($boost * 5);

    $total += $strength;

    if (($n['type'] ?? '') === 'signal') $signals++;
    if (($n['type'] ?? '') === 'anomaly') $risk++;
}

/* STATE ENGINE */
$avg = count($nodes) ? $total / count($nodes) : 0;

if ($risk > $signals * 2) {
    $state = "critical instability";
    $action = "isolate anomalies + halt expansion";
} elseif ($signals > $risk * 2) {
    $state = "growth acceleration";
    $action = "scale signal tracking + expand ingestion";
} elseif ($avg > 60) {
    $state = "high activity stable";
    $action = "monitor high-value clusters";
} else {
    $state = "low activity";
    $action = "increase data intake";
}

/* CASE TRIGGER */
$case = null;

if ($risk > 5) {
    $case = "Anomaly cluster detected";
}

/* OUTPUT */
$result = [
    "network_id"=>$network_id,
    "state"=>$state,
    "recommended_action"=>$action,
    "avg_strength"=>$avg,
    "signals"=>$signals,
    "risk"=>$risk,
    "case"=>$case,
    "timestamp"=>date("Y-m-d H:i:s")
];

/* SAVE SNAPSHOT */
$historyDir = __DIR__ . "/../../data/history/";
if (!is_dir($historyDir)) mkdir($historyDir, 0777, true);

file_put_contents(
    $historyDir . $network_id . "_" . time() . ".json",
    json_encode($result, JSON_PRETTY_PRINT)
);

echo json_encode($result);
;
    echo json_encode($response);
exit;
