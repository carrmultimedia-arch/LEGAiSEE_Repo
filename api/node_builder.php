<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$network_id = $input['network_id'] ?? '';
$type = $input['type'] ?? 'insight';

$node = [
    "id"=>uniqid("node_"),
    "type"=>$type,
    "created_at"=>date("Y-m-d H:i:s"),
    "value"=>$input['value'] ?? '',
    "strength"=>rand(40,100)
];

$path = __DIR__."/../data/network/".$network_id.".json";

if(!file_exists($path)){
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($path), true);

$network['nodes'][] = $node;

file_put_contents($path, json_encode($network, JSON_PRETTY_PRINT));

echo json_encode($node);