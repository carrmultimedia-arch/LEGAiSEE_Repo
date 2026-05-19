<?php
header('Content-Type: application/json');

$network_id = $_POST['network_id'] ?? '';

$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

if(!file_exists($file)){
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($file), true);

$compressed = [];
$seen = [];

foreach($network['nodes'] as $n){

    $key = strtolower($n['type']);

    if(isset($seen[$key])){
        $compressed[$key]['strength'] += $n['strength'];
        $compressed[$key]['count']++;
    } else {
        $compressed[$key] = [
            "type"=>$key,
            "strength"=>$n['strength'],
            "count"=>1
        ];
        $seen[$key] = true;
    }
}

file_put_contents(
    __DIR__ . "/../../data/compressed/" . $network_id . ".json",
    json_encode($compressed, JSON_PRETTY_PRINT)
);

echo json_encode([
    "compressed_nodes"=>$compressed
]);