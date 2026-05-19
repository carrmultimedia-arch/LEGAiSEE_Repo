<?php

function createClient($name){

    $id = "client_" . time();

    $path = __DIR__ . "/../data/clients/$id/";

    mkdir($path, 0777, true);

    $profile = [
        "id" => $id,
        "name" => $name,
        "created_at" => date("c")
    ];

    file_put_contents($path . "profile.json", json_encode($profile, JSON_PRETTY_PRINT));

    return $profile;
}

function getClients(){

    $base = __DIR__ . "/../data/clients/";

    $clients = [];

    if(!is_dir($base)) return [];

    foreach(scandir($base) as $dir){

        if($dir === '.' || $dir === '..') continue;

        $profileFile = $base . $dir . "/profile.json";

        if(file_exists($profileFile)){
            $clients[] = json_decode(file_get_contents($profileFile), true);
        }
    }

    return $clients;
}