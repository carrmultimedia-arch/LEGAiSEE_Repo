<?php

/*
================================================
LEGAISEE DECISION GOVERNOR v1.0
Final execution authority layer
================================================
*/

function evaluateExecution($context, $goals, $plan, $task){

    $score = 100;

    /*
    ================================================
    RULE 1: GOAL ALIGNMENT REQUIREMENT
    ================================================
    */

    if(!isGoalAligned($task, $goals)){
        $score -= 80;
    }

    /*
    ================================================
    RULE 2: PLAN CONSISTENCY CHECK
    ================================================
    */

    if(!isPlanConsistent($task, $plan)){
        $score -= 40;
    }

    /*
    ================================================
    RULE 3: SYSTEM LOAD PROTECTION
    ================================================
    */

    if($context['node_count'] > 500){
        $score -= 20;
    }

    /*
    ================================================
    RULE 4: MUTATION SAFETY LIMIT
    ================================================
    */

    if(($task['type'] ?? '') === 'graph_mutation'
       && ($task['risk'] ?? 0) > 70){
        $score -= 60;
    }

    /*
    ================================================
    FINAL DECISION
    ================================================
    */

    return [
        "approved" => $score >= 60,
        "score" => $score
    ];
}