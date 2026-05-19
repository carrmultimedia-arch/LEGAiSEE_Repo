#!/usr/local/bin/php.cli
<?php

$logDir = __DIR__ . "/../data/reasoning_log/";
$perfFile = __DIR__ . "/../data/chains/chain_performance.json";
$templateFile = __DIR__ . "/../data/chains/chain_templates.json";

$logs = glob($logDir . "*.json");

$performance = file_exists($perfFile)
    ? json_decode(file_get_contents($perfFile), true)
    : [];

$chains = json_decode(file_get_contents($templateFile), true);

if (!$logs || !$chains) {
    echo "no data\n";
    exit;
}

/* STEP 1: SCORE CHAIN OUTCOMES */

foreach ($logs as $logFile) {

    $log = json_decode(file_get_contents($logFile), true);
    if (!$log) continue;

    $decision = $log['decision'] ?? 'MONITOR';
    $risk = $log['risk_score'] ?? 0;

    $chainKey = "default";

    /* classify outcome quality */
    $outcomeScore = 0;

    if ($decision === "ESCALATE" && $risk > 40) {
        $outcomeScore = 1; // correct escalation
    } elseif ($decision === "PROCEED" && $risk < 20) {
        $outcomeScore = 1;
    } elseif ($decision === "MONITOR") {
        $outcomeScore = 0.5;
    } else {
        $outcomeScore = -1; // bad decision
    }

    $performance[] = [
        "chain"=>$chainKey,
        "score"=>$outcomeScore,
        "risk"=>$risk,
        "decision"=>$decision,
        "time"=>date("Y-m-d H:i:s")
    ];
}

/* STEP 2: AGGREGATE PERFORMANCE */

$stats = [];

foreach ($performance as $p) {

    $chain = $p['chain'];

    if (!isset($stats[$chain])) {
        $stats[$chain] = [
            "total_score"=>0,
            "count"=>0
        ];
    }

    $stats[$chain]["total_score"] += $p["score"];
    $stats[$chain]["count"]++;
}

/* STEP 3: CALCULATE WEIGHTS */

$weights = [];

foreach ($stats as $chain => $s) {

    $avg = $s["count"] ? $s["total_score"] / $s["count"] : 0;

    $weights[$chain] = $avg;
}

/* STEP 4: APPLY EVOLUTION RULES */

foreach ($chains as $eventType => &$chainSteps) {

    foreach ($chainSteps as &$step) {

        $action = $step['action'];

        /* strengthen or weaken steps based on performance */
        if (isset($weights[$eventType])) {

            if ($weights[$eventType] > 0.7) {
                $step['weight'] = ($step['weight'] ?? 1) + 0.1;
            }

            if ($weights[$eventType] < 0.3) {
                $step['weight'] = ($step['weight'] ?? 1) - 0.1;
            }
        }
    }
}

/* STEP 5: SAVE EVOLVED CHAINS */

file_put_contents(
    $templateFile,
    json_encode($chains, JSON_PRETTY_PRINT)
);

file_put_contents(
    $perfFile,
    json_encode($performance, JSON_PRETTY_PRINT)
);

echo "chains evolved\n";