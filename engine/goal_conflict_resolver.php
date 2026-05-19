<?php

/*
================================================
GOAL CONFLICT RESOLVER v1.0
Eliminates contradictory objectives
================================================
*/

function resolveGoalConflicts($goals){

    $resolved = [];

    foreach($goals as $g){

        $conflict = false;

        foreach($resolved as $r){

            if(isConflicting($g, $r)){
                $conflict = true;

                // keep higher priority only
                if(($g['priority_score'] ?? 0) > ($r['priority_score'] ?? 0)){
                    $r = $g;
                }

                break;
            }
        }

        if(!$conflict){
            $resolved[] = $g;
        }
    }

    return $resolved;
}

/*
================================================
CONFLICT DETECTION RULES
================================================
*/
function isConflicting($a, $b){

    if(($a['type'] ?? '') === 'optimization' &&
       ($b['type'] ?? '') === 'deletion') {
        return true;
    }

    if($a['source_cluster'] ?? '' === $b['source_cluster'] ?? ''){
        return false;
    }

    return false;
}