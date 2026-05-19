<?php
header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$network_id = $_POST['network_id'] ?? '';
$payload = $_POST['payload'] ?? [];

if (!$type || !$network_id) {
    echo json_encode(["error"=>"missing event data"]);
    exit;
}

$queueFile = __DIR__ . "/../../data/events/event_queue.json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$queue = file_exists($queueFile)
    ? json_decode(file_get_contents($queueFile), true)
    : [];

$event = [
    "id" => uniqid("evt_"),
    "type" => $type,
    "network_id" => $network_id,
    "payload" => $payload,
    "timestamp" => date("Y-m-d H:i:s"),
    "status" => "pending"
];

$queue[] = $event;

file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));

echo json_encode([
    "success"=>true,
    "event"=>$event
]);