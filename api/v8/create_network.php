<?php
header('Content-Type: application/json');

$id = "net_" . uniqid();

$file = __DIR__ . "/../../data/network/" . $id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = [
    "id"=>$id,
    "created_at"=>date("Y-m-d H:i:s"),
    "nodes"=>[],
    "edges"=>[],
    "status"=>"active"
];

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode([
    "success"=>true,
    "network_id"=>$id
]);