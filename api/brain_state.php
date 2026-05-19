<?php
header('Content-Type: application/json');

$brain_id = $_GET['brain_id'] ?? '';

$file = __DIR__."/../data/brains/".$brain_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"brain not found"]);
    exit;
}

echo file_get_contents($file);