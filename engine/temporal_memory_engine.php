<?php

/*
================================================
LEGAISEE TEMPORAL MEMORY ENGINE v1.0
Stores evolving system state across time
================================================
*/

function writeTemporalMemory($conn, $case_id, $graph, $goals){

    $snapshot = [
        "case_id" => $case_id,
        "timestamp" => date("c"),
        "graph_summary" => summarizeGraph($graph),
        "goal_state" => summarizeGoals($goals),
        "metrics" => computeMetrics($graph, $goals)
    ];

    $json = $conn->real_escape_string(json_encode($snapshot));

    $conn->query("
        INSERT INTO temporal_memory
        (case_id, snapshot_json, created_at)
        VALUES
        ($case_id, '$json', NOW())
    ");
}

/*
================================================
GRAPH SUMMARY (COMPRESSION)
================================================
*/
function summarizeGraph($graph){

    return [
        "node_count" => count($graph['nodes'] ?? []),
        "edge_count" => count($graph['edges'] ?? []),
        "avg_strength" => averageStrength($graph['nodes'] ?? [])
    ];
}

/*
================================================
GOAL SUMMARY
================================================
*/
function summarizeGoals($goals){

    return [
        "active_goal_count" => count($goals),
        "avg_priority" => array_sum(array_column($goals,'priority_score')) / max(1,count($goals))
    ];
}

/*
================================================
METRICS ENGINE
================================================
*/
function computeMetrics($graph, $goals){

    return [
        "system_density" => count($graph['nodes'] ?? []) / max(1, count($goals)),
        "goal_pressure" => count($goals) * 1.2
    ];
}

/*
================================================
UTILITY
================================================
*/
function averageStrength($nodes){

    if(count($nodes) === 0) return 0;

    $sum = 0;

    foreach($nodes as $n){
        $sum += $n['strength'] ?? 0;
    }

    return $sum / count($nodes);
}