<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| LEGAiSEE — CROSS-CASE LEARNING COMPILER
|------------------------------------------------------------
| PURPOSE:
| - Aggregate learning signals across ALL cases + clients
| - Build system-wide intelligence weights
| - Distinguish universal patterns vs case-specific noise
|------------------------------------------------------------
*/

$systemDir = __DIR__ . '/../data/system/';

$feedbackFile = $systemDir . 'feedback_events.json';
$learningFile = $systemDir . 'learning_adjustments.json';

$weightsFile  = $systemDir . 'cross_case_weights.json';
$globalFile   = $systemDir . 'global_intelligence_map.json';

/*
|------------------------------------------------------------
| LOAD INPUT DATA
|------------------------------------------------------------
*/

$feedback = file_exists($feedbackFile)
    ? json_decode(file_get_contents($feedbackFile), true)
    : [];

$adjustments = file_exists($learningFile)
    ? json_decode(file_get_contents($learningFile), true)
    : [];

if (!is_array($feedback)) $feedback = [];
if (!is_array($adjustments)) $adjustments = [];

/*
|------------------------------------------------------------
| AGGREGATION STRUCTURES
|------------------------------------------------------------
*/

$moduleScores = [];
$actionScores = [];
$riskScores = [];

$totalEvents = 0;

/*
|------------------------------------------------------------
| PROCESS FEEDBACK EVENTS
|------------------------------------------------------------
*/

foreach ($feedback as $event) {

    $totalEvents++;

    $module = $event['module'] ?? 'unknown';
    $action = $event['action'] ?? 'unknown';
    $risk = $event['risk'] ?? 'low';
    $delta = $event['learning_delta'] ?? 0;

    /*
    |--------------------------------------------------------
    | MODULE SCORE TRACKING
    |--------------------------------------------------------
    */

    if (!isset($moduleScores[$module])) {
        $moduleScores[$module] = [
            "success" => 0,
            "failure" => 0,
            "total" => 0
        ];
    }

    if ($delta > 0) $moduleScores[$module]['success']++;
    if ($delta < 0) $moduleScores[$module]['failure']++;

    $moduleScores[$module]['total']++;

    /*
    |--------------------------------------------------------
    | ACTION SCORE TRACKING
    |--------------------------------------------------------
    */

    if (!isset($actionScores[$action])) {
        $actionScores[$action] = 0;
    }

    $actionScores[$action] += $delta;

    /*
    |--------------------------------------------------------
    | RISK PROFILE LEARNING
    |--------------------------------------------------------
    */

    if (!isset($riskScores[$risk])) {
        $riskScores[$risk] = [
            "success" => 0,
            "failure" => 0,
            "total" => 0
        ];
    }

    if ($delta > 0) $riskScores[$risk]['success']++;
    if ($delta < 0) $riskScores[$risk]['failure']++;

    $riskScores[$risk]['total']++;
}

/*
|------------------------------------------------------------
| COMPUTE NORMALIZED WEIGHTS
|------------------------------------------------------------
*/

$weights = [];

foreach ($moduleScores as $module => $data) {

    $total = max(1, $data['total']);
    $score = ($data['success'] - $data['failure']) / $total;

    $weights[$module] = [
        "score" => round($score, 4),
        "confidence" => min(1, $total / 50), // more data = higher confidence
        "classification" => ($score > 0.2)
            ? "high_value"
            : (($score < -0.2) ? "low_value" : "neutral")
    ];
}

/*
|------------------------------------------------------------
| GLOBAL INTELLIGENCE MAP
|------------------------------------------------------------
*/

$globalMap = [
    "total_events" => $totalEvents,
    "module_weights" => $weights,
    "action_bias" => $actionScores,
    "risk_performance" => $riskScores,
    "system_stability" => $totalEvents > 0 ? "active_learning" : "cold_start",
    "last_compiled" => date('c')
];

/*
|------------------------------------------------------------
| WRITE OUTPUTS
|------------------------------------------------------------
*/

if (!is_dir($systemDir)) {
    mkdir($systemDir, 0777, true);
}

file_put_contents(
    $weightsFile,
    json_encode($weights, JSON_PRETTY_PRINT)
);

file_put_contents(
    $globalFile,
    json_encode($globalMap, JSON_PRETTY_PRINT)
);

/*
|------------------------------------------------------------
| RETURN STATUS
|------------------------------------------------------------
*/

return [
    "status" => "ok",
    "total_events_processed" => $totalEvents,
    "modules_scored" => count($weights),
    "output_weights" => $weightsFile,
    "output_global_map" => $globalFile
];