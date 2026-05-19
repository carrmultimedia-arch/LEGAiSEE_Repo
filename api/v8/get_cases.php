<?php

header('Content-Type: application/json');

$client_id = $_GET['client_id'] ?? '';

$base = __DIR__ . "/../../data/clients/$client_id/cases/";

$cases = [];

if(is_dir($base)){

    foreach(scandir($base) as $dir){

        if($dir === '.' || $dir === '..') continue;

        $metaFile = $base . $dir . "/meta.json";

        if(file_exists($metaFile)){
            $cases[] = json_decode(file_get_contents($metaFile), true);
        }
    }
}

echo json_encode($cases);