#!/usr/local/bin/php.cli
<?php

$network_id = "net_69eee12e374d30_99173905";
$path = __DIR__ . "/../data/network/" . $network_id . ".json";

if (!file_exists($path)) {
    echo "network missing\n";
    exit;
}

$network = json_decode(file_get_contents($path), true);
$nodes = $network['nodes'] ?? [];

$total = 0;
$risk = 0;
$signals = 0;

foreach ($nodes as $n) {
    $total += $n['strength'] ?? 0;

    if (($n['type'] ?? '') === 'signal') $signals++;
    if (($n['type'] ?? '') === 'anomaly') $risk++;
}

$avg = count($nodes) ? $total / count($nodes) : 0;

if ($risk > $signals * 2) {
    $state = "critical instability";
} elseif ($signals > $risk * 2) {
    $state = "growth phase";
} else {
    $state = "stable";
}

/* WRITE LOG */
$logDir = __DIR__ . "/../data/auto_log/";
if (!is_dir($logDir)) mkdir($logDir, 0777, true);

file_put_contents(
    $logDir . "run_" . time() . ".json",
    json_encode([
        "state"=>$state,
        "avg"=>$avg,
        "signals"=>$signals,
        "risk"=>$risk,
        "time"=>date("Y-m-d H:i:s")
    ], JSON_PRETTY_PRINT)
);

echo "OK\n";