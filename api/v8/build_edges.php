<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$data = json_decode(file_get_contents($file), true);

$nodes = $data['nodes'] ?? [];

$edges = [];

/* STABLE RULE:
   only sequential connections (deterministic) */

for ($i = 0; $i < count($nodes) - 1; $i++) {
    $edges[] = [
        "from" => $nodes[$i]['id'],
        "to" => $nodes[$i+1]['id'],
        "type" => "sequence",
        "weight" => 1
    ];
}

$data['edges'] = $edges;

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode([
    "success"=>true,
    "edges_created"=>count($edges)
]);echo json_encode($response);
exit;