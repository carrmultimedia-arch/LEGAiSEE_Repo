<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| LEGAiSEE — EXECUTION FEEDBACK ENGINE
|------------------------------------------------------------
| PURPOSE:
| - Evaluate executed actions vs outcomes
| - Generate learning signals
| - Feed adjustments back into prediction + recommendation layers
|------------------------------------------------------------
*/

$systemDir = __DIR__ . '/../data/system/';

$logFile      = $systemDir . 'execution_log.json';
$activeFile   = $systemDir . 'active_actions.json';
$resultFile   = $systemDir . 'execution_results.json';

$feedbackFile = $systemDir . 'feedback_events.json';
$learningFile = $systemDir . 'learning_adjustments.json';

/*
|------------------------------------------------------------
| LOAD DATA
|------------------------------------------------------------
*/

$executions = file_exists($logFile)
    ? json_decode(file_get_contents($logFile), true)
    : [];

$active = file_exists($activeFile)
    ? json_decode(file_get_contents($activeFile), true)
    : [];

$results = file_exists($resultFile)
    ? json_decode(file_get_contents($resultFile), true)
    : [];

if (!is_array($executions)) $executions = [];
if (!is_array($active)) $active = [];
if (!is_array($results)) $results = [];

/*
|------------------------------------------------------------
| INDEX RESULTS BY ACTION (if available)
|------------------------------------------------------------
*/

$resultIndex = [];

foreach ($results as $r) {
    $key = $r['execution_id'] ?? ($r['action'] ?? null);
    if ($key) {
        $resultIndex[$key] = $r;
    }
}

/*
|------------------------------------------------------------
| FEEDBACK COLLECTION
|------------------------------------------------------------
*/

$feedback = [];
$learningAdjustments = [];

foreach ($executions as $exec) {

    $execId = $exec['id'] ?? null;

    if (!$execId) continue;

    $result = $resultIndex[$execId] ?? null;

    /*
    |--------------------------------------------------------
    | DEFAULT ASSUMPTION = FAILURE (important for learning bias)
    |--------------------------------------------------------
    */

    $status = "unknown";
    $delta = 0;

    if ($result) {
        $status = $result['status'] ?? "unknown";

        if ($status === "success") {
            $delta = +1;
        } elseif ($status === "partial") {
            $delta = 0;
        } elseif ($status === "failure") {
            $delta = -1;
        }
    }

    /*
    |--------------------------------------------------------
    | FEEDBACK EVENT
    |--------------------------------------------------------
    */

    $feedback[] = [
        "execution_id" => $execId,
        "action" => $exec['route']['action'] ?? null,
        "module" => $exec['route']['module'] ?? null,
        "confidence" => $exec['confidence'] ?? 0,
        "risk" => $exec['risk'] ?? 'low',
        "result_status" => $status,
        "learning_delta" => $delta,
        "timestamp" => date('c')
    ];

    /*
    |--------------------------------------------------------
    | LEARNING ADJUSTMENTS (SYSTEM MEMORY UPDATE SIGNALS)
    |--------------------------------------------------------
    */

    if ($delta !== 0) {

        $learningAdjustments[] = [
            "pattern" => $exec['route']['module'] ?? 'unknown',
            "adjustment_type" => ($delta > 0)
                ? "reinforce"
                : "deprecate",

            "weight_change" => $delta * 0.1,
            "reason" => "execution_feedback",
            "timestamp" => date('c')
        ];
    }
}

/*
|------------------------------------------------------------
| WRITE OUTPUTS
|------------------------------------------------------------
*/

if (!is_dir($systemDir)) {
    mkdir($systemDir, 0777, true);
}

file_put_contents(
    $feedbackFile,
    json_encode($feedback, JSON_PRETTY_PRINT)
);

file_put_contents(
    $learningFile,
    json_encode($learningAdjustments, JSON_PRETTY_PRINT)
);

/*
|------------------------------------------------------------
| RETURN STATUS
|------------------------------------------------------------
*/

return [
    "status" => "ok",
    "feedback_events" => count($feedback),
    "learning_signals" => count($learningAdjustments),
    "feedback_file" => $feedbackFile,
    "learning_file" => $learningFile
];