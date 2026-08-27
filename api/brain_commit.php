<?php
header('Content-Type: application/json');

session_start();

$input = json_decode(file_get_contents("php://input"), true);

$brain_id = $input['brain_id'] ?? $_SESSION['brain_id'] ?? '';
$note = $input['note'] ?? '';

if(!$brain_id){
    echo json_encode(["error"=>"brain_id not found in session or input"]);
    exit;
}

$file = __DIR__."/../data/brains/".$brain_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"brain not found"]);
    exit;
}

$session = json_decode(file_get_contents($file), true);

$session['steps'][] = [
    "manual_note"=>$note,
    "timestamp"=>date("H:i:s")
];

file_put_contents($file, json_encode($session, JSON_PRETTY_PRINT));

echo json_encode(["success"=>true]);