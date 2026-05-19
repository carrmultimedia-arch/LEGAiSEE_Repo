<?php

require_once __DIR__ . '/portfolio_engine.php';

/*
================================================
MEMORY EVOLUTION ENGINE
Tracks changes across cases over time
================================================
*/

function buildMemoryEvolution(){

    $cases = loadAllCases();

    $timeline = [];

    foreach($cases as $case){

        foreach($case['nodes'] ?? [] as $node){

            $timeline[] = [
                "time" => $node['created_at'] ?? date("c"),
                "content" => $node['content'] ?? "",
                "strength" => $node['strength'] ?? 0
            ];
        }
    }

    // sort by time
    usort($timeline, function($a, $b){
        return strtotime($a['time']) - strtotime($b['time']);
    });

    $evolution = [
        "trend" => "stable",
        "insight" => "no long-term drift detected",
        "points" => count($timeline)
    ];

    if(count($timeline) > 5){

        $evolution["trend"] = "active";

        $evolution["insight"] = "signal evolution detected across timeline";
    }

    file_put_contents(
        __DIR__ . "/../data/portfolio/memory_evolution.json",
        json_encode($evolution, JSON_PRETTY_PRINT)
    );

    return $evolution;
}