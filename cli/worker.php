<?php

require_once __DIR__ . '/../engine/cluster_engine.php';
require_once __DIR__ . '/../engine/reasoning_engine.php';
require_once __DIR__ . '/../engine/recommendation_engine.php';
require_once __DIR__ . '/../engine/pipeline_adapters.php';
require_once __DIR__ . '/../engine/system_insight_engine.php';
require_once __DIR__ . '/../engine/predictive_intelligence_engine.php';
buildPredictiveInsights();

$base = __DIR__ . "/../data/clients/";
require_once __DIR__ . '/../engine/predictive_intelligence_engine.php';

buildPredictiveInsights();

$processed_total = 0;

foreach(scandir($base) as $client){

    if($client === '.' || $client === '..') continue;

    $casesPath = $base . $client . "/cases/";

    if(!is_dir($casesPath)) continue;

    foreach(scandir($casesPath) as $case){

        if($case === '.' || $case === '..') continue;

        $case_id = $case;

        $path = $casesPath . $case . "/";

        $graphFile = $path . "network.json";
        $queueFile = $path . "tasks/queue.json";

        if(!file_exists($queueFile)) continue;

        $graph = json_decode(file_get_contents($graphFile), true);
        $queue = json_decode(file_get_contents($queueFile), true);

        $processed = 0;

        foreach($queue as $task){

            if(($task['type'] ?? '') === 'add_node'){

                $graph['nodes'][] = [
                    "id" => uniqid("n_"),
                    "type" => "signal",
                    "strength" => 100,
                    "content" => $task['content'],
                    "created_at" => date("c")
                ];

                $processed++;
            }
        }

        file_put_contents($queueFile, json_encode([], JSON_PRETTY_PRINT));
        file_put_contents($graphFile, json_encode($graph, JSON_PRETTY_PRINT));

        /*
        RUN INTELLIGENCE STACK
        */

        clusterNodesPath($path);
        generateInsightsPath($path);
        generateRecommendationsPath($path);

        $processed_total += $processed;
    }
}

echo json_encode([
    "status" => "worker_complete",
    "processed_total" => $processed_total
]);

generateSystemInsights();
generateRecommendationsFromPath($path);
