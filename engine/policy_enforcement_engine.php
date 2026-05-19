<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| LEGAiSEE — POLICY ENFORCEMENT ENGINE
|------------------------------------------------------------
| PURPOSE:
| - Enforce system-wide recommendations as execution constraints
| - Build a governed execution context for downstream engines
| - Prevent unsafe or contradictory system behavior
|
| INPUT:
| - /data/system/system_recommendations.json
|
| OUTPUT:
| - /data/system/policy_enforced_context.json
|------------------------------------------------------------
*/

$systemDir = __DIR__ . '/../data/system/';
$policyFile = $systemDir . 'system_recommendations.json';
$outputFile = $systemDir . 'policy_enforced_context.json';

if (!file_exists($policyFile)) {
    return [
        "status" => "error",
        "message" => "system_recommendations.json missing"
    ];
}

$policies = json_decode(file_get_contents($policyFile), true) ?? [];

$activePolicies = [];
$globalMode = "normal";

/*
|------------------------------------------------------------
| POLICY FILTERING + PRIORITY RESOLUTION
|------------------------------------------------------------
*/

foreach ($policies as $policy) {

    $type = $policy['policy_type'] ?? '';
    $level = $policy['enforcement_level'] ?? 'low';

    /*
    |--------------------------------------------------------
    | CRITICAL + SYSTEM POLICIES ALWAYS ACTIVE
    |--------------------------------------------------------
    */
    if (in_array($level, ['critical', 'system', 'high'])) {

        $activePolicies[] = $policy;
    }

    /*
    |--------------------------------------------------------
    | DETECT GLOBAL SYSTEM MODE
    |--------------------------------------------------------
    */
    if ($type === 'global_mode') {
        $globalMode = 'stabilization';
    }
}

/*
|------------------------------------------------------------
| BUILD ENFORCEMENT CONTEXT
|------------------------------------------------------------
*/

$context = [
    "system_mode" => $globalMode,
    "active_policy_count" => count($activePolicies),
    "constraints" => [],
    "engine_rules" => [],
    "execution_flags" => []
];

/*
|------------------------------------------------------------
| TRANSLATE POLICIES INTO EXECUTION CONSTRAINTS
|------------------------------------------------------------
*/

foreach ($activePolicies as $p) {

    $title = strtolower($p['title'] ?? '');
    $rule  = $p['rule'] ?? '';
    $appliesTo = $p['applies_to'] ?? [];

    /*
    |--------------------------------------------------------
    | ENGAGEMENT CONSTRAINT
    |--------------------------------------------------------
    */
    if (str_contains($title, 'engagement')) {

        $context['constraints'][] = [
            "type" => "engagement_guard",
            "rule" => "Block engagement-increasing actions if trend is unstable",
            "applies_to" => $appliesTo
        ];

        $context['execution_flags'][] = "ENGAGEMENT_LOCK";
    }

    /*
    |--------------------------------------------------------
    | OUTPUT CONTROL CONSTRAINT
    |--------------------------------------------------------
    */
    if (str_contains($title, 'content') || str_contains($title, 'volume')) {

        $context['constraints'][] = [
            "type" => "output_throttle",
            "rule" => "Prevent uncontrolled content scaling without performance validation",
            "applies_to" => $appliesTo
        ];

        $context['execution_flags'][] = "OUTPUT_THROTTLE_ACTIVE";
    }

    /*
    |--------------------------------------------------------
    | RISK-FIRST EXECUTION RULE
    |--------------------------------------------------------
    */
    if (str_contains($title, 'risk')) {

        $context['constraints'][] = [
            "type" => "risk_gate",
            "rule" => "All growth actions require risk validation before execution",
            "applies_to" => $appliesTo
        ];

        $context['execution_flags'][] = "RISK_GATE_REQUIRED";
    }

    /*
    |--------------------------------------------------------
    | SYSTEM STABILITY MODE
    |--------------------------------------------------------
    */
    if ($p['policy_type'] === 'global_mode') {

        $context['engine_rules'][] = [
            "type" => "system_mode_override",
            "value" => "stabilization-first execution mode enabled"
        ];
    }
}

/*
|------------------------------------------------------------
| FINAL SYSTEM EXECUTION PROFILE
|------------------------------------------------------------
*/

$context['execution_profile'] = [
    "mode" => $globalMode,
    "risk_tolerance" => $globalMode === "stabilization" ? "low" : "adaptive",
    "automation_level" => count($activePolicies) > 3 ? "restricted" : "normal"
];

/*
|------------------------------------------------------------
| WRITE OUTPUT
|------------------------------------------------------------
*/

if (!is_dir($systemDir)) {
    mkdir($systemDir, 0777, true);
}

file_put_contents(
    $outputFile,
    json_encode($context, JSON_PRETTY_PRINT)
);

/*
|------------------------------------------------------------
| RETURN FOR PIPELINE
|------------------------------------------------------------
*/

return [
    "status" => "ok",
    "policies_enforced" => count($activePolicies),
    "system_mode" => $globalMode,
    "output_file" => $outputFile
];