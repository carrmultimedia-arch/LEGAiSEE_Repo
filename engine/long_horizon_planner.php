<?php

/*
================================================
LONG-HORIZON PLANNER v1.0
Simulates future system states from current graph
================================================
*/

function generatePlan($graph, $goals, $history){

    $plan = [];

    /*
    ================================================
    STEP 1: DETECT TRAJECTORY FROM HISTORY
    ================================================
    */

    $trend = detectTrend($history);

    /*
    ================================================
    STEP 2: ALIGN GOALS TO TREND
    ================================================
    */

    foreach($goals as $g){

        $adjusted_priority = $g['priority_score'];

        if($trend['direction'] === 'growth'){
            $adjusted_priority *= 1.1;
        }

        if($trend['direction'] === 'decline'){
            $adjusted_priority *= 0.9;
        }

        $plan[] = [
            "goal" => $g['title'],
            "adjusted_priority" => $adjusted_priority,
            "time_horizon" => estimateHorizon($g)
        ];
    }

    /*
    ================================================
    STEP 3: FUTURE STATE SIMULATION
    ================================================
    */

    $projection = simulateNextState($graph, $goals);

    return [
        "trend" => $trend,
        "plan" => $plan,
        "projection" => $projection
    ];
}

/*
================================================
TREND DETECTION
================================================
*/
function detectTrend($history){

    if(count($history) < 2){
        return ["direction" => "stable"];
    }

    $latest = end($history);
    $previous = prev($history);

    $delta = ($latest['metrics']['goal_pressure'] ?? 0)
           - ($previous['metrics']['goal_pressure'] ?? 0);

    if($delta > 5) return ["direction" => "growth"];
    if($delta < -5) return ["direction" => "decline"];

    return ["direction" => "stable"];
}

/*
================================================
HORIZON ESTIMATION
================================================
*/
function estimateHorizon($goal){

    return match($goal['type'] ?? '') {
        'investigation' => 'short',
        'optimization' => 'mid',
        'growth' => 'long',
        default => 'mid'
    };
}

/*
================================================
FUTURE SIMULATION (LIGHTWEIGHT MODEL)
================================================
*/
function simulateNextState($graph, $goals){

    return [
        "predicted_node_growth" => count($graph['nodes'] ?? []) * 1.05,
        "predicted_goal_saturation" => count($goals) + 2
    ];
}