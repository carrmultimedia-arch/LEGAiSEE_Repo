<?php
header('Content-Type: application/json');

$networkDir = __DIR__ . "/../../data/network/";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$mesh = [];

foreach(glob($networkDir . "*.json") as $file){

    $network = json_decode(file_get_contents($file), true);

    foreach($network['nodes'] as $n){

        $type = $n['type'];

        if(!isset($mesh[$type])){
            $mesh[$type] = 0;
        }

        $mesh[$type]++;
    }
}

file_put_contents(
    __DIR__ . "/../../data/mesh/global_mesh.json",
    json_encode($mesh, JSON_PRETTY_PRINT)
);

echo json_encode([
    "mesh"=>$mesh
]);
echo json_encode($response);
exit;
