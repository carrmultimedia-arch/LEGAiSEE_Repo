<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| LEGAiSEE — SYSTEM RECOMMENDATION ENGINE
|------------------------------------------------------------
| PURPOSE:
| - Convert system insights into actionable system-wide directives
| - Influence ALL downstream decision engines
| - Establish global behavioral policies
|
| INPUT:
| - /data/system/system_insights.json
|
| OUTPUT:
| - /data/system/system_recommendations.json
|------------------------------------------------------------
*/

$systemDir = __DIR__ . '/../data/system/';
$insightFile = $systemDir . 'system_insights.json';
$outputFile  = $systemDir . 'system_recommendations.json';

if (!file_exists($insightFile)) {
    return [
        "status" => "error",
        "message" => "system_insights.json missing"
    ];
}

$insights = json_decode(file_get_contents($insightFile), true) ?? [];

$recommendations = [];

/*
|------------------------------------------------------------
| GLOBAL POLICY GENERATION
|------------------------------------------------------------
*/

foreach ($insights as $insight) {

    $type = $insight['type'] ?? '';
    $title = $insight['title'] ?? '';

    /*
    |--------------------------------------------------------
    | POLICY 1: ENGAGEMENT STABILIZATION
    |--------------------------------------------------------
    */
    if (str_contains(strtolower($title), 'engagement')) {

        $recommendations[] = [
            "policy_type" => "system_behavior_control",
            "title" => "Prioritize Engagement Stability Over Volume",
            "rule" =>
                "Do not increase output frequency unless engagement trend is stable or improving.",
            "enforcement_level" => "high",
            "applies_to" => [
                "predictive_engine",
                "decision_engine",
                "client_case_systems"
            ],
            "reasoning" =>
                "System-wide engagement decay detected across multiple cases.",
            "created_at" => date('c')
        ];
    }

    /*
    |--------------------------------------------------------
    | POLICY 2: OUTPUT LIMITATION RULE
    |--------------------------------------------------------
    */
    if (str_contains(strtolower($title), 'output') || str_contains(strtolower($title), 'inflation')) {

        $recommendations[] = [
            "policy_type" => "content_strategy_rule",
            "title" => "Limit Content Volume Scaling",
            "rule" =>
                "Content scaling must be gated by performance signals, not schedule-based automation.",
            "enforcement_level" => "high",
            "applies_to" => [
                "ingest_engine",
                "content_scheduler",
                "predictive_engine"
            ],
            "reasoning" =>
                "Output inflation patterns show negative correlation with engagement.",
            "created_at" => date('c')
        ];
    }

    /*
    |--------------------------------------------------------
    | POLICY 3: RISK-FIRST SCALING
    |--------------------------------------------------------
    */
    if (str_contains(strtolower($title), 'risk')) {

        $recommendations[] = [
            "policy_type" => "scaling_policy",
            "title" => "Risk Evaluation Before Expansion",
            "rule" =>
                "All growth or scaling actions must pass risk evaluation threshold before execution.",
            "enforcement_level" => "critical",
            "applies_to" => [
                "decision_engine",
                "predictive_engine",
                "client_growth_system"
            ],
            "reasoning" =>
                "Growth amplifies unresolved risk structures across multiple cases.",
            "created_at" => date('c')
        ];
    }

    /*
    |--------------------------------------------------------
    | POLICY 4: SYSTEM STABILITY MODE
    |--------------------------------------------------------
    */
    if (str_contains(strtolower($title), 'system')) {

        $recommendations[] = [
            "policy_type" => "global_mode",
            "title" => "System Stability Preference Activated",
            "rule" =>
                "Default system behavior should prioritize stability over expansion when uncertainty is present.",
            "enforcement_level" => "system",
            "applies_to" => [
                "all_engines"
            ],
            "reasoning" =>
                "Multiple system-level instabilities detected in cross-case patterns.",
            "created_at" => date('c')
        ];
    }
}

/*
|------------------------------------------------------------
| GLOBAL META POLICY SUMMARY
|------------------------------------------------------------
*/

$recommendations[] = [
    "policy_type" => "meta_summary",
    "title" => "System Governance Snapshot",
    "rule" =>
        "System is currently operating in stabilization-first mode due to recurring cross-case instability patterns.",
    "enforcement_level" => "system",
    "applies_to" => ["global"],
    "created_at" => date('c')
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
    json_encode($recommendations, JSON_PRETTY_PRINT)
);

/*
|------------------------------------------------------------
| RETURN PIPELINE STATUS
|------------------------------------------------------------
*/

return [
    "status" => "ok",
    "recommendations_generated" => count($recommendations),
    "output_file" => $outputFile
];