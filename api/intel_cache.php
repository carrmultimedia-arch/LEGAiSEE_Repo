<?php
header('Content-Type: application/json');

$file = __DIR__."/intel_cache.json";

if(!file_exists($file)){
    echo json_encode(["error"=>"no cache"]);
    exit;
}

echo file_get_contents($file);