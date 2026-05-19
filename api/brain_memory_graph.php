<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? '';
$node = $input['node'] ?? [];

$dir = __DIR__."/../data/brains/";

if(!is_dir($dir)){
    mkdir($dir, 0777, true);
}

$path = $dir."graph.json";

$graph = file_exists($path)
    ? json_decode(file_get_contents($path), true)
    : [];

$graph[] = [
    "file"=>$file,
    "node"=>$node,
    "timestamp"=>date("Y-m-d H:i:s")
];

file_put_contents($path, json_encode($graph, JSON_PRETTY_PRINT));

echo json_encode(["success"=>true]);