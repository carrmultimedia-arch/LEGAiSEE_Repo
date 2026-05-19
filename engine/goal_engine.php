<?php

/*
================================================
LEGAISEE GOAL ENGINE v1.0
Defines system intent and directional control
================================================
*/

function loadGoals($case_id, $conn){

    $res = $conn->query("
        SELECT * FROM goals
        WHERE case_id = $case_id
        AND status = 'active'
    ");

    $goals = [];

    while($row = $res->fetch_assoc()){

        $goals[] = [
            "id" => $row['id'],
            "title" => $row['title'],
            "type" => $row['type'],
            "priority" => $row['priority'],
            "target_metric" => $row['target_metric'],
            "current_value" => $row['current_value']
        ];
    }

    return $goals;
}
require_once __DIR__ . '/goal_arbitration_engine.php';
require_once __DIR__ . '/goal_conflict_resolver.php';

/*
========================================
ARBITRATION GATE
========================================
*/

$proposals = loadGoalProposals($conn, $case_id);

$arbitrated = arbitrateGoals($proposals);

$final_goals = resolveGoalConflicts($arbitrated);

saveActiveGoals($conn, $final_goals, $case_id);
