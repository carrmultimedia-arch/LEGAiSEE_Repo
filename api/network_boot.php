<?php
header('Content-Type: application/json');

/* SAFE ID (NO DOTS) */
$id = "net_" . str_replace('.', '_', uniqid('', true));

$network = [
    "id"=>$id,
    "created_at"=>date("Y-m-d H:i:s"),
    "nodes"=>[],
    "edges"=>[],
    "event_queue"=>[],
    "status"=>"active"
];

if(!is_dir(__DIR__."/../data/network/")){
    mkdir(__DIR__."/../data/network/", 0777, true);
}

file_put_contents(
    __DIR__."/../data/network/".$id.".json",
    json_encode($network, JSON_PRETTY_PRINT)
);

echo json_encode($network);