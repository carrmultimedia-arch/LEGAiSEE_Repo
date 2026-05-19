<?php
header('Content-Type: application/json');

/*
In production this would be cron-driven.
For now: manual trigger endpoint.
*/

$dir = __DIR__."/../data/cases/";

$results = [];

foreach(glob($dir."*.json") as $file){

    $case = json_decode(file_get_contents($file), true);

    /* simulate condition for re-analysis */
    $shouldTick = rand(0,1) === 1;

    if($shouldTick){

        $case['status']="queued_for_tick";

        $results[] = [
            "case"=>$case['id'],
            "action"=>"queued"
        ];
    }
}

echo json_encode([
    "processed"=>count($results),
    "results"=>$results
]);