<?php

function loadClusters($case_id){
    $file = __DIR__ . "/../data/cases/$case_id/clusters.json";

    if(!file_exists($file)){
        return [];
    }

    return json_decode(file_get_contents($file), true);
}

function saveClusters($case_id, $clusters){
    $file = __DIR__ . "/../data/cases/$case_id/clusters.json";
    file_put_contents($file, json_encode($clusters, JSON_PRETTY_PRINT));
}

/*
================================================
BASIC SEMANTIC CLUSTERING
================================================
*/

function clusterNodes($case_id){

    $graphFile = __DIR__ . "/../data/cases/$case_id/network.json";

    if(!file_exists($graphFile)) return;

    $graph = json_decode(file_get_contents($graphFile), true);

    $clusters = [];

    foreach($graph['nodes'] as $node){

        $content = strtolower($node['content'] ?? '');

        if(!$content) continue;

        /*
        SIMPLE KEYWORD GROUPING (V1)
        */

        if(strpos($content, 'risk') !== false){
            $clusters['market_risk'][] = $node;
        }
        elseif(strpos($content, 'growth') !== false){
            $clusters['growth'][] = $node;
        }
        elseif(strpos($content, 'opportunity') !== false){
            $clusters['opportunity'][] = $node;
        }
        else{
            $clusters['general'][] = $node;
        }
    }

    saveClusters($case_id, $clusters);
}