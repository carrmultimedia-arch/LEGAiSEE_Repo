<?php
header('Content-Type: application/json');

$id = uniqid("agency_", true);

$agency = [
    "id"=>$id,
    "created_at"=>date("Y-m-d H:i:s"),
    "cases"=>[],
    "agents"=>[],
    "global_memory"=>[],
    "status"=>"active"
];

if(!is_dir(__DIR__."/../data/agency/")){
    mkdir(__DIR__."/../data/agency/", 0777, true);
}

file_put_contents(__DIR__."/../data/agency/".$id.".json", json_encode($agency, JSON_PRETTY_PRINT));

echo json_encode($agency);