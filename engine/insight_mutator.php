<?php

function extractMutationsFromInsights($insights){

    $mutation_pack = [];

    foreach($insights as $i){

        if(($i['strength'] ?? 0) > 60){

            $mutation_pack[] = [
                "cluster" => $i['cluster'] ?? "unknown",
                "strength" => $i['strength'],
                "text" => $i['insight'] ?? "pattern detected"
            ];
        }
    }

    return $mutation_pack;
}