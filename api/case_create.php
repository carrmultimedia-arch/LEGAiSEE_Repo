<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? '';
$name = $input['name'] ?? 'unnamed_case';

if(!$file){
    echo json_encode(["error"=>"missing file"]);
    exit;
}

$id = uniqid("case_", true);

$case = [
    "id"=>$id,
    "name"=>$name,
    "file"=>$file,
    "created_at"=>date("Y-m-d H:i:s"),
    "last_tick"=>null,
    "status"=>"active",
    "memory"=>[],
    "dossier"=>[]
];

if(!is_dir(__DIR__."/../data/cases/")){
    mkdir(__DIR__."/../data/cases/", 0777, true);
}

file_put_contents(__DIR__."/../data/cases/".$id.".json", json_encode($case, JSON_PRETTY_PRINT));

echo json_encode($case);