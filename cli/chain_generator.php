#!/usr/local/bin/php.cli
<?php

$base = realpath(__DIR__ . "/..");

$logDir = $base . "/data/reasoning_log/";
$genFile = $base . "/data/chains/chain_genome.json";
$templateFile = $base . "/data/chains/chain_templates.json";

if (!file_exists($logDir)) {
    echo "no logs\n";
    exit;
}

$logs = glob($logDir . "*.json");

$genome = file_exists($genFile)
    ? json_decode(file_get_contents($genFile), true)
    : ["step_pool"=>[], "generated_chains"=>[]];

$chains = file_exists($templateFile)
    ? json_decode(file_get_contents($templateFile), true)
    : [];

/**
 * STEP 1: EXTRACT HIGH VALUE STEPS FROM LOGS
 */
$stepFrequency = [];

foreach ($logs as $logFile) {

    $log = json_decode(file_get_contents($logFile), true);
    if (!$log) continue;

    foreach (($log['trace'] ?? []) as $step) {

        if (!isset($stepFrequency[$step])) {
            $stepFrequency[$step] = 0;
        }

        $stepFrequency[$step]++;
    }
}

/**
 * BUILD STEP POOL (TOP SIGNAL STEPS ONLY)
 */
arsort($stepFrequency);

$topSteps = array_slice($stepFrequency, 0, 10, true);

$genome['step_pool'] = array_keys($topSteps);

/**
 * STEP 2: GENERATE NEW CHAINS
 */
$newChains = [];

foreach ($chains as $eventType => $chainSet) {

    $bestSteps = $genome['step_pool'];

    if (count($bestSteps) < 3) continue;

    // create a hybrid chain
    $newChain = [
        "chain_id" => "auto_" . uniqid(),
        "steps" => []
    ];

    // randomly assemble a structured chain (deterministic subset)
    for ($i = 0; $i < min(4, count($bestSteps)); $i++) {

        $action = $thisStep = $bestSteps[$i];

        // map trace phrase back to actions (simplified normalization)
        $mappedAction = "analyze_node_strength";

        if (strpos($action, "risk") !== false) {
            $mappedAction = "determine_risk_state";
        }

        if (strpos($action, "anomaly") !== false) {
            $mappedAction = "cluster_anomaly_check";
        }

        if (strpos($action, "impact") !== false) {
            $mappedAction = "evaluate_network_impact";
        }

        $newChain['steps'][] = [
            "action" => $mappedAction,
            "weight" => 1
        ];
    }

    if (!empty($newChain['steps'])) {
        $newChains[] = $newChain;
    }
}

/**
 * STEP 3: INJECT GENERATED CHAINS
 */
foreach ($newChains as $chain) {

    foreach ($chains as $eventType => &$chainSet) {

        // inject into every event type as exploratory candidate
        $chainSet[] = $chain;
    }
}

$genome['generated_chains'] = array_merge(
    $genome['generated_chains'],
    $newChains
);

/**
 * SAVE UPDATED STATE
 */
file_put_contents($genFile, json_encode($genome, JSON_PRETTY_PRINT));
file_put_contents($templateFile, json_encode($chains, JSON_PRETTY_PRINT));

echo "chains generated: " . count($newChains) . "\n";