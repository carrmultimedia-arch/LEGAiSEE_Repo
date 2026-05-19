<?php

require_once __DIR__ . '/../db.php';

echo "🧠 Graph Scheduler Engine v1.0 ONLINE\n";

/*
================================================
LOAD GRAPH
================================================
*/
function loadGraph($case_id, $conn){

    $res = $conn->query("
        SELECT * FROM cases WHERE id=$case_id
    ");

    $case = $res->fetch_assoc();

    $path = __DIR__ . "/../data/network/net_case_" . $case_id . ".json";

    if(!file_exists($path)){
        return null;
    }

    return json_decode(file_get_contents($path), true);
}

/*
================================================
PRIORITY SCORING ENGINE
================================================
*/
function calculatePriority(&$node){

    $base = $node['strength'] ?? 10;

    $typeWeight = match($node['type'] ?? '') {
        "anomaly" => 1.4,
        "insight" => 1.3,
        "signal" => 1.0,
        "task" => 1.1,
        default => 1.0
    };

    $dependencyPenalty = isset($node['dependencies'])
        ? count($node['dependencies']) * 2
        : 0;

    $node['priority_score'] =
        ($base * $typeWeight) - $dependencyPenalty;

    return $node['priority_score'];
}

/*
================================================
GRAPH DEPTH CALCULATION (BFS STYLE)
================================================
*/
function computeDepths(&$graph){

    $nodes = &$graph['nodes'];
    $edges = $graph['edges'];

    $map = [];

    foreach($nodes as &$n){
        $n['depth'] = 999;
        $map[$n['id']] = &$n;
    }

    // root nodes
    foreach($nodes as &$n){
        if(!isset($n['dependencies']) || empty($n['dependencies'])){
            $n['depth'] = 0;
        }
    }

    // propagate depth
    for($i=0; $i<5; $i++){
        foreach($edges as $e){

            $from = $e['from'];
            $to = $e['to'];

            if(isset($map[$from]) && isset($map[$to])){

                $newDepth = $map[$from]['depth'] + 1;

                if($newDepth < $map[$to]['depth']){
                    $map[$to]['depth'] = $newDepth;
                }
            }
        }
    }
}

/*
================================================
SCHEDULING ENGINE
================================================
*/
function buildSchedule(&$graph){

    $nodes = &$graph['nodes'];

    foreach($nodes as &$n){
        calculatePriority($n);
    }

    computeDepths($graph);

    usort($nodes, function($a, $b){

        $scoreA = ($a['priority_score'] ?? 0) - ($a['depth'] ?? 0);
        $scoreB = ($b['priority_score'] ?? 0) - ($b['depth'] ?? 0);

        return $scoreB <=> $scoreA;
    });

    return $nodes;
}

/*
================================================
EXECUTION PLAN OUTPUT
================================================
*/
function emitExecutionPlan($scheduled){

    $plan = [];

    foreach($scheduled as $n){

        if(($n['priority_score'] ?? 0) < 10){
            continue;
        }

        $plan[] = [
            "node_id" => $n['id'],
            "type" => $n['type'],
            "priority" => $n['priority_score'],
            "depth" => $n['depth'],
            "action" => "execute"
        ];
    }

    return $plan;
}

/*
================================================
RUN
================================================
*/
$case_id = 1;

$graph = loadGraph($case_id, $conn);

if(!$graph){
    die("No graph found\n");
}

$scheduled = buildSchedule($graph);

$plan = emitExecutionPlan($scheduled);

file_put_contents(
    __DIR__ . "/../data/network/schedule_case_{$case_id}.json",
    json_encode($plan, JSON_PRETTY_PRINT)
);

echo "✅ schedule generated: " . count($plan) . " tasks\n";