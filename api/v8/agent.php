<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);
$nodes = $data['nodes'] ?? [];

$state = "unknown";
$risk = 0;
$signal = 0;

foreach ($nodes as $n) {
    if (($n['type'] ?? '') === 'signal') $signal++;
    if (($n['type'] ?? '') === 'anomaly') $risk++;
}

if ($risk > $signal * 2) {
    $state = "critical instability";
} elseif ($signal > $risk * 2) {
    $state = "strong growth phase";
} else {
    $state = "balanced state";
}

/* SIMPLE DECISION LOOP */
$action = "";

if ($state === "critical instability") {
    $action = "halt expansion + isolate anomaly clusters";
} elseif ($state === "strong growth phase") {
    $action = "scale signal tracking + increase ingestion";
} else {
    $action = "monitor and maintain baseline observation";
}

echo json_encode([
    "state"=>$state,
    "recommended_action"=>$action,
    "signal"=>$signal,
    "risk"=>$risk;
    echo json_encode($response);
exit;

