#!/usr/local/bin/php.cli
<?php

$base = realpath(__DIR__ . "/..");

$goalFile = $base . "/data/goals/goals.json";
$metaFile = $base . "/data/goals/meta_goals.json";
$logDir = $base . "/data/reasoning_log/";

if (!file_exists($goalFile) || !file_exists($metaFile)) {
    echo "missing files\n";
    exit;
}

$goals = json_decode(file_get_contents($goalFile), true) ?: [];
$metaGoals = json_decode(file_get_contents($metaFile), true) ?: [];

$logs = glob($logDir . "*.json");

if (!$logs) {
    echo "no logs\n";
    exit;
}

/**
 * STEP 1: ANALYZE SYSTEM PERFORMANCE SIGNALS
 */
$decisionStats = [
    "ESCALATE" => 0,
    "PROCEED" => 0,
    "MONITOR" => 0
];

$falseEscalations = 0;
$total = 0;

foreach ($logs as $logFile) {

    $log = json_decode(file_get_contents($logFile), true);
    if (!$log) continue;

    $decision = $log['decision'] ?? null;
    if (!$decision) continue;

    $decisionStats[$decision]++;

    $risk = $log['risk_score'] ?? 0;

    if ($decision === "ESCALATE" && $risk < 30) {
        $falseEscalations++;
    }

    $total++;
}

/**
 * STEP 2: META-GOAL DRIVEN ADJUSTMENT
 */
foreach ($metaGoals as $meta) {

    switch ($meta['meta_goal_id']) {

        case "reduce_false_escalations":

            if ($falseEscalations > ($total * 0.2)) {

                // penalize aggressive goals
                foreach ($goals as &$g) {
                    if ($g['goal_id'] === "anomaly_detection") {
                        $g['weight'] = max(0.5, ($g['weight'] ?? 1) - 0.1);
                    }
                }
            }
            break;

        case "optimize_decision_accuracy":

            $accuracy = ($decisionStats["PROCEED"] + $decisionStats["MONITOR"]) / max(1, $total);

            if ($accuracy < 0.6) {
                foreach ($goals as &$g) {
                    $g['weight'] = ($g['weight'] ?? 1) + 0.1;
                }
            }
            break;

        case "increase_signal_quality":

            $noise = $decisionStats["MONITOR"] / max(1, $total);

            if ($noise > 0.5) {
                foreach ($goals as &$g) {
                    if ($g['goal_id'] === "network_stability") {
                        $g['weight'] = ($g['weight'] ?? 1) + 0.2;
                    }
                }
            }
            break;
    }
}

/**
 * STEP 3: GOAL EVOLUTION (CREATE / REMOVE / MODIFY)
 */

// Example: if system is too stable → introduce exploration goal
$stabilityRatio = $decisionStats["MONITOR"] / max(1, $total);

if ($stabilityRatio > 0.7) {

    $goals[] = [
        "goal_id" => "exploration_boost_" . time(),
        "priority" => 5,
        "weight" => 1.0,
        "status" => "active",
        "target_metrics" => [
            "increase_variance" => true
        ]
    ];
}

/**
 * STEP 4: SAVE UPDATED SYSTEM STATE
 */
file_put_contents($goalFile, json_encode($goals, JSON_PRETTY_PRINT));
file_put_contents($metaFile, json_encode($metaGoals, JSON_PRETTY_PRINT));

echo "meta-goal cycle complete\n";