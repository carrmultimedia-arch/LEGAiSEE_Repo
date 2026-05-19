<?php

/*
================================================
SEMANTIC CLUSTERING ENGINE (BASELINE+)
================================================
*/

function buildSemanticClusters($nodes){

    $clusters = [];

    foreach($nodes as $node){

        $text = strtolower($node['content'] ?? '');

        $assigned = false;

        // semantic grouping (not strict keyword matching)

        if(containsAny($text, ["engagement", "reach", "views", "audience"])){
            $clusters["audience_performance"][] = $node;
            $assigned = true;
        }

        if(containsAny($text, ["risk", "decline", "drop", "falling"])){
            $clusters["risk_signals"][] = $node;
            $assigned = true;
        }

        if(containsAny($text, ["growth", "opportunity", "expand"])){
            $clusters["growth_signals"][] = $node;
            $assigned = true;
        }

        if(!$assigned){
            $clusters["unclassified"][] = $node;
        }
    }

    return $clusters;
}

function containsAny($text, $keywords){

    foreach($keywords as $k){
        if(strpos($text, $k) !== false) return true;
    }

    return false;
}