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

echo file_get_contents($file);