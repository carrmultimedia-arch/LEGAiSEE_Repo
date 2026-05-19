<?php

/*
================================================
PATTERN STABILITY ENGINE
Prevents unstable or noise-based goal creation
================================================
*/

function isStablePattern($items){

    if(count($items) < 5){
        return false;
    }

    $strengths = array_map(fn($i) => $i['strength'] ?? 0, $items);

    $mean = array_sum($strengths) / count($strengths);

    $variance = 0;

    foreach($strengths as $s){
        $variance += pow($s - $mean, 2);
    }

    $variance /= count($strengths);

    /*
    ================================================
    STABILITY RULE
    ================================================
    */

    if($variance > 400){
        return false; // too chaotic
    }

    return true;
}