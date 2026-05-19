<?php

/*
================================================
LEGAISEE AUTONOMOUS GOAL GENERATION v1.0
Controlled objective synthesis from graph signals
================================================
*/

function generateGoalCandidates($graph, $conn){

    $nodes = $graph['nodes'] ?? [];

    $clusters = [];

    /*
    ================================================
    STEP 1: GROUP BY SEMANTIC CLUSTER
    ================================================
    */

    foreach($nodes as $n){

        $cluster = $n['cluster'] ?? 'uncategorized';

        if(!isset($clusters[$cluster])){
            $clusters[$cluster] = [];
        }

        $clusters[$cluster][] = $n;
    }

    $goal_candidates = [];

    /*
    ================================================
    STEP 2: DETECT STABLE PATTERNS
    ================================================
    */

    foreach($clusters as $name => $items){

        $strength_sum = 0;
        $count = count($items);

        foreach($items as $i){
            $strength_sum += ($i['strength'] ?? 0);
        }

        $avg_strength = $count > 0 ? $strength_sum / $count : 0;

        /*
        ================================================
        GOAL THRESHOLD RULE
        ================================================
        */

        if($count >= 5 && $avg_strength >= 60){

            $goal_candidates[] = [
                "title" => "Optimize cluster: " . $name,
                "type" => "optimization",
                "source_cluster" => $name,
                "confidence" => min(100, $avg_strength),
                "status" => "proposed",
                "generated_at" => date("c")
            ];
        }

        /*
        ================================================
        ANOMALY DRIVEN GOAL GENERATION
        ================================================
        */

        $anomalies = array_filter($items, function($i){
            return ($i['type'] ?? '') === 'anomaly';
        });

        if(count($anomalies) >= 3){

            $goal_candidates[] = [
                "title" => "Investigate anomaly cluster: " . $name,
                "type" => "investigation",
                "source_cluster" => $name,
                "confidence" => 75,
                "status" => "proposed",
                "generated_at" => date("c")
            ];
        }
    }

    return $goal_candidates;
}