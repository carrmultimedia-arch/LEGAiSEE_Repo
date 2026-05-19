<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? '';
$brain_id = uniqid("brain_", true);

$path = __DIR__ . "/../normalized/" . $file;

if(!file_exists($path)){
    echo json_encode(["error"=>"file not found"]);
    exit;
}

$session = [
    "brain_id"=>$brain_id,
    "file"=>$file,
    "steps"=>[],
    "created_at"=>date("Y-m-d H:i:s"),
    "status"=>"active"
];

file_put_contents(__DIR__."/../data/brains/".$brain_id.".json", json_encode($session, JSON_PRETTY_PRINT));

echo json_encode($session);