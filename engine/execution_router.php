<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| LEGAiSEE — EXECUTION ROUTER
|------------------------------------------------------------
| PURPOSE:
| - Take approved decisions and route them into execution layers
| - Map actions to client + case contexts
| - Produce execution logs and active action queues
|------------------------------------------------------------
*/

$systemDir = __DIR__ . '/../data/system/';

$decisionFile = $systemDir . 'decisions.json';
$logFile      = $systemDir . 'execution_log.json';
$activeFile   = $systemDir . 'active_actions.json';

/*
|------------------------------------------------------------
| LOAD DECISIONS
|------------------------------------------------------------
*/

$decisions = file_exists($decisionFile)
    ? json_decode(file_get_contents($decisionFile), true)
    : [];

if (!is_array($decisions)) {
    $decisions = [];
}

/*
|------------------------------------------------------------
| EXECUTION BUCKETS
|------------------------------------------------------------
*/

$executionLog = [];
$activeActions = [];

/*
|------------------------------------------------------------
| ROUTING CORE
|------------------------------------------------------------
*/

foreach ($decisions as $d) {

    if (!($d['approved'] ?? false)) {
        continue;
    }

    $action = $d['action'] ?? 'unknown';

    /*
    |--------------------------------------------------------
    | DEFAULT ROUTING MODEL
    |--------------------------------------------------------
    | If your system expands later:
    | - client_id
    | - case_id
    | - module target
    |--------------------------------------------------------
    */

    $route = [
        "client_id" => $d['client_id'] ?? "global",
        "case_id"   => $d['case_id'] ?? "global",
        "module"    => "system_core",
        "action"    => $action
    ];

    /*
    |--------------------------------------------------------
    | ACTION CLASSIFICATION
    |--------------------------------------------------------
    */

    $type = "general";

    if (str_contains(strtolower($action), 'content')) {
        $type = "content";
    }

    if (str_contains(strtolower($action), 'risk')) {
        $type = "risk_control";
    }

    if (str_contains(strtolower($action), 'growth')) {
        $type = "growth_opportunity";
    }

    /*
    |--------------------------------------------------------
    | BUILD EXECUTION ENTRY
    |--------------------------------------------------------
    */

    $executionEntry = [
        "id" => uniqid("exec_", true),
        "type" => $type,
        "route" => $route,
        "confidence" => $d['confidence'] ?? 0,
        "risk" => $d['risk'] ?? 'low',
        "timestamp" => date('c'),
        "status" => "queued"
    ];

    $executionLog[] = $executionEntry;

    /*
    |--------------------------------------------------------
    | ACTIVE ACTION QUEUE
    |--------------------------------------------------------
    */

    $activeActions[] = [
        "action" => $action,
        "module" => $route['module'],
        "priority" => ($d['risk'] === 'high') ? "high" : "normal",
        "client" => $route['client_id'],
        "case" => $route['case_id']
    ];
}

/*
|------------------------------------------------------------
| WRITE OUTPUT FILES
|------------------------------------------------------------
*/

if (!is_dir($systemDir)) {
    mkdir($systemDir, 0777, true);
}

file_put_contents(
    $logFile,
    json_encode($executionLog, JSON_PRETTY_PRINT)
);

file_put_contents(
    $activeFile,
    json_encode($activeActions, JSON_PRETTY_PRINT)
);

/*
|------------------------------------------------------------
| RETURN PIPELINE RESULT
|------------------------------------------------------------
*/

return [
    "status" => "ok",
    "executed" => count($executionLog),
    "active_actions" => count($activeActions),
    "log_file" => $logFile,
    "active_file" => $activeFile
];