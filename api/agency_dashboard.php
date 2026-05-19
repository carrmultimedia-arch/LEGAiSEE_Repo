<?php
header('Content-Type: application/json');

$dir = __DIR__."/../data/agency/";

$agencies = [];

foreach(glob($dir."*.json") as $file){
    $agencies[] = json_decode(file_get_contents($file), true);
}

echo json_encode([
    "active_agencies"=>count($agencies),
    "agencies"=>$agencies
]);