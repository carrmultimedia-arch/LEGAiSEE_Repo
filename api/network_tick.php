<?php
header('Content-Type: application/json');

$network_id = $_POST['network_id'] ?? '';

$file = __DIR__."/../data/network/".$network_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($file), true);

/*
Simulated evolution loop:
- detect anomalies
- spawn nodes
- link relationships
*/

$newNodeChance = rand(0,1);

if($newNodeChance){

    $node = [
        "id"=>uniqid("auto_node_"),
        "type"=>"emergent_insight",
        "value"=>"Self-generated pattern synthesis",
        "strength"=>rand(60,100),
        "created_at"=>date("Y-m-d H:i:s")
    ];

    $network['nodes'][] = $node;
}

$network['last_tick'] = date("Y-m-d H:i:s");

file_put_contents($file, json_encode($network, JSON_PRETTY_PRINT));

echo json_encode([
    "status"=>"tick_complete",
    "nodes"=>count($network['nodes']),
    "edges"=>count($network['edges'])
]);