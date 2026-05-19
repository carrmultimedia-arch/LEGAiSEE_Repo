<?php

require_once __DIR__ . '/insight_generator.php';

/*
|--------------------------------------------------------------------------
| RECOMMENDATION ACTION SYSTEM
|--------------------------------------------------------------------------
| Converts insights into executable business actions
*/

function generateActionsFromInsight($insightBlock) {

    $cluster = strtolower($insightBlock['cluster'] ?? '');
    $insights = $insightBlock['insights'] ?? [];

    $actions = [];

    foreach ($insights as $text) {

        $t = strtolower($text);

        /*
        |--------------------------------------------------------------------------
        | RULE-BASED ACTION ENGINE
        |--------------------------------------------------------------------------
        */

        // MARKETING ACTIONS
        if (strpos($t, 'marketing') !== false || strpos($cluster, 'marketing') !== false) {

            $actions[] = [
                "priority" => "high",
                "action" => "Develop a 30-day content strategy focused on short-form video distribution.",
                "category" => "marketing"
            ];

            $actions[] = [
                "priority" => "medium",
                "action" => "Audit current social media channels for engagement gaps.",
                "category" => "marketing"
            ];
        }

        // SOCIAL MEDIA ACTIONS
        if (strpos($t, 'social') !== false || strpos($cluster, 'social') !== false) {

            $actions[] = [
                "priority" => "high",
                "action" => "Increase posting frequency to 3–5 times per week on Instagram and Facebook.",
                "category" => "social"
            ];

            $actions[] = [
                "priority" => "medium",
                "action" => "Repurpose existing content into short-form reels and clips.",
                "category" => "social"
            ];
        }

        // WEBSITE / CONVERSION ACTIONS
        if (strpos($t, 'website') !== false || strpos($cluster, 'website') !== false) {

            $actions[] = [
                "priority" => "high",
                "action" => "Optimize landing page conversion flow and simplify call-to-action structure.",
                "category" => "web"
            ];

            $actions[] = [
                "priority" => "medium",
                "action" => "Run UX audit focused on mobile usability and bounce rate reduction.",
                "category" => "web"
            ];
        }

        // DEFAULT ACTION IF NOTHING MATCHES
        if (empty($actions)) {
            $actions[] = [
                "priority" => "low",
                "action" => "Perform deeper analysis of cluster before assigning operational strategy.",
                "category" => "analysis"
            ];
        }
    }

    return $actions;
}

/*
|--------------------------------------------------------------------------
| MAIN ACTION GENERATOR
|--------------------------------------------------------------------------
*/

function generateRecommendations($network_file) {

    $insights = generateInsights($network_file);

    $allActions = [];

    foreach ($insights as $insightBlock) {

        $actions = generateActionsFromInsight($insightBlock);

        $allActions[] = [
            "cluster" => $insightBlock['cluster'],
            "actions" => $actions
        ];
    }

    return $allActions;
}