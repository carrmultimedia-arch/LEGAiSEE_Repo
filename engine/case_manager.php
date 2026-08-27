<?php

function createCase($client_id, $name){

    $case_id = "case_" . time();

    $path = __DIR__ . "/../data/clients/$client_id/cases/$case_id/";

    mkdir($path . "tasks/", 0777, true);

    file_put_contents($path . "network.json", json_encode([
        "nodes" => [],
        "edges" => []
    ], JSON_PRETTY_PRINT));

    $meta = [
        "id" => $case_id,
        "name" => $name,
        "created_at" => date("c")
    ];

    file_put_contents($path . "meta.json", json_encode($meta, JSON_PRETTY_PRINT));

    return $meta;
}