<?php
header('Content-Type: application/json');

$id = $_GET['id'] ?? '';

$file = __DIR__."/../data/cases/".$id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"case not found"]);
    exit;
}

echo file_get_contents($file);