<?php

/*
================================================
LOAD ALL CASES ACROSS ALL CLIENTS
================================================
*/

function loadAllCases(){

    $base = __DIR__ . "/../data/clients/";

    $cases = [];

    if(!is_dir($base)) return $cases;

    foreach(scandir($base) as $client){

        if($client === '.' || $client === '..') continue;

        $caseDir = $base . $client . "/cases/";

        if(!is_dir($caseDir)) continue;

        foreach(scandir($caseDir) as $case){

            if($case === '.' || $case === '..') continue;

            $graphFile = $caseDir . $case . "/network.json";

            if(file_exists($graphFile)){
                $cases[] = json_decode(file_get_contents($graphFile), true);
            }
        }
    }

    return $cases;
}

/*
================================================
BUILD GLOBAL CROSS-CASE GRAPH
================================================
*/

function buildGlobalGraph(){

    $cases = loadAllCases();

    $globalNodes = [];

    foreach($cases as $case){

        foreach($case['nodes'] ?? [] as $node){

            $globalNodes[] = $node;
        }
    }

    return [
        "nodes" => $globalNodes,
        "generated_at" => date("c")
    ];
}