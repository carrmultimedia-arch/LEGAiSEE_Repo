<?php
header('Content-Type: application/json');

$brain_id = $_GET['brain_id'] ?? '';

$file = __DIR__."/../data/brains/".$brain_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"brain not found"]);
    exit;
}

$session = json_decode(file_get_contents($file), true);

$steps = $session['steps'] ?? [];

$dossier = [
    "FILE"=>$session['file'],
    "BRAIN_ID"=>$brain_id,
    "STATUS"=>$session['status'],
    "STEP_COUNT"=>count($steps),
    "LATEST_INSIGHT"=>$steps ? end($steps) : null,
    "FULL_TIMELINE"=>$steps,
    "CLASSIFICATION"=>"LIVE EXCAVATION NODE v3"
];

echo json_encode($dossier);