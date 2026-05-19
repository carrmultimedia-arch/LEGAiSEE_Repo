<?php

/*
================================================
LEGAISEE GRAPH MUTATION ENGINE v1.0
Controlled self-rewriting intelligence layer
================================================
*/

function mutateGraph(&$graph, $insights){

    $nodes = &$graph['nodes'];
    $edges = &$graph['edges'];

    /*
    ================================================
    RULE 1: INSIGHT → NODE EXPANSION
    ================================================
    */

    foreach($insights as $insight){

        if(!isset($insight['cluster'])) continue;

        $node_id = "m_" . uniqid();

        $nodes[] = [
            "id" => $node_id,
            "type" => "insight",
            "strength" => $insight['strength'] ?? 50,
            "content" => $insight['text'] ?? "auto-generated insight",
            "created_at" => date("c"),
            "source_cluster" => $insight['cluster']
        ];
    }

    /*
    ================================================
    RULE 2: HIGH-STRENGTH PROMOTION
    ================================================
    */

    foreach($nodes as &$n){

        if(($n['strength'] ?? 0) > 80){

            $n['type'] = "priority_signal";
            $n['priority_boost'] = true;
        }
    }

    /*
    ================================================
    RULE 3: EDGE REINFORCEMENT
    ================================================
    */

    foreach($edges as &$e){

        if(rand(0,10) > 7){
            $e['weight'] = ($e['weight'] ?? 1) + 1;
        }
    }

    /*
    ================================================
    RULE 4: SOFT SELF-EXPANSION (LIMITED)
    ================================================
    */

    if(count($nodes) < 200){

        $nodes[] = [
            "id" => "auto_" . uniqid(),
            "type" => "signal",
            "strength" => rand(40, 70),
            "content" => "emergent pattern detected",
            "created_at" => date("c")
        ];
    }

    return $graph;
}