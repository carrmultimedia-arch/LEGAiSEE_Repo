<?php
header('Content-Type: application/json');

session_start();

$brain_id = $_GET['brain_id'] ?? $_SESSION['brain_id'] ?? '';

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

$steps = $session['steps'] ?? [];

$dossier = [
    "FILE"=>$session['file'],
    "NODE_ID"=>$session['node_id'] ?? null,
    "BRAIN_ID"=>$brain_id,
    "STATUS"=>$session['status'],
    "STEP_COUNT"=>count($steps),
    "LATEST_INSIGHT"=>$steps ? end($steps) : null,
    "FULL_TIMELINE"=>$steps,
    "CLASSIFICATION"=>"LIVE EXCAVATION NODE v3"
];

echo json_encode($dossier);