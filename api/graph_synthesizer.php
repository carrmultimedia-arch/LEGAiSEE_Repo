<?php
header('Content-Type: application/json');

$network_id = $_GET['network_id'] ?? '';

$file = __DIR__."/../data/network/".$network_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($file), true);

$nodes = $network['nodes'];

$clusters = [];

foreach($nodes as $n){

    $key = $n['type'];

    if(!isset($clusters[$key])){
        $clusters[$key] = 0;
    }

    $clusters[$key]++;
}

$synthesis = [
    "network_id"=>$network_id,
    "total_nodes"=>count($nodes),
    "cluster_map"=>$clusters,
    "dominant_pattern"=>array_key_first($clusters),
    "system_state"=>"self-organizing"
];

echo json_encode($synthesis);