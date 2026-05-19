<?php

/*
================================================
GOAL ALIGNMENT ENGINE
Measures whether graph moves toward objectives
================================================
*/

function scoreNodeAgainstGoals($node, $goals){

    $score = 0;

    foreach($goals as $g){

        // simple semantic overlap heuristic
        if(strpos($node['content'] ?? '', $g['title']) !== false){
            $score += 30;
        }

        // strength contributes to goal relevance
        $score += ($node['strength'] ?? 0) * 0.2;

        // priority boosts alignment
        $score += ($node['priority_score'] ?? 0) * 0.3;
    }

    return $score;
}