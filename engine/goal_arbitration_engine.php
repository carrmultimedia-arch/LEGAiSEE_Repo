<?php

/*
================================================
LEGAISEE GOAL ARBITRATION ENGINE v1.0
Resolves conflicts + ranks system objectives
================================================
*/

function arbitrateGoals($proposals){

    $final = [];

    /*
    ================================================
    STEP 1: REMOVE LOW CONFIDENCE GOALS
    ================================================
    */

    $filtered = array_filter($proposals, function($g){
        return ($g['confidence'] ?? 0) >= 60;
    });

    /*
    ================================================
    STEP 2: GROUP BY SEMANTIC TITLE SIMILARITY
    ================================================
    */

    $clusters = [];

    foreach($filtered as $g){

        $key = normalizeGoalKey($g['title']);

        if(!isset($clusters[$key])){
            $clusters[$key] = [];
        }

        $clusters[$key][] = $g;
    }

    /*
    ================================================
    STEP 3: MERGE DUPLICATES
    ================================================
    */

    foreach($clusters as $group){

        if(count($group) == 1){
            $final[] = $group[0];
            continue;
        }

        $merged = mergeGoals($group);
        $final[] = $merged;
    }

    /*
    ================================================
    STEP 4: PRIORITY SCORING
    ================================================
    */

    foreach($final as &$g){

        $base = $g['confidence'] ?? 0;

        $type_weight = match($g['type'] ?? '') {
            'optimization' => 1.2,
            'investigation' => 1.3,
            'growth' => 1.5,
            default => 1.0
        };

        $g['priority_score'] = $base * $type_weight;
    }

    /*
    ================================================
    STEP 5: SORT FINAL GOALS
    ================================================
    */

    usort($final, function($a, $b){
        return ($b['priority_score'] ?? 0) <=> ($a['priority_score'] ?? 0);
    });

    /*
    ================================================
    STEP 6: LIMIT ACTIVE GOALS (ANTI-EXPLOSION)
    ================================================
    */

    return array_slice($final, 0, 10);
}

/*
================================================
NORMALIZATION FUNCTION
================================================
*/
function normalizeGoalKey($title){

    $title = strtolower($title);
    $title = preg_replace('/[^a-z0-9 ]/', '', $title);
    $title = trim($title);

    return substr(md5($title), 0, 10);
}

/*
================================================
GOAL MERGER
================================================
*/
function mergeGoals($group){

    $best = $group[0];

    $confidence_sum = 0;

    foreach($group as $g){
        $confidence_sum += $g['confidence'];
    }

    $best['confidence'] = $confidence_sum / count($group);

    $best['title'] = $best['title'] . " (merged " . count($group) . ")";

    return $best;
}