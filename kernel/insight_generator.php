<?php

require_once __DIR__ . '/cluster_intelligence.php';

/*
|--------------------------------------------------------------------------
| INSIGHT GENERATOR LAYER
|--------------------------------------------------------------------------
| Converts clusters into actionable business intelligence
*/

function generateInsightText($cluster) {

    $label = $cluster['label'] ?? 'unknown';
    $size  = $cluster['size'] ?? 0;
    $strength = $cluster['strength'] ?? 0;

    /*
    |--------------------------------------------------------------------------
    | SIMPLE RULE ENGINE (upgrade later to AI)
    |--------------------------------------------------------------------------
    */

    $insights = [];

    // HIGH PRIORITY CLUSTERS
    if ($strength > 300) {
        $insights[] = "High-impact cluster detected in '{$label}' area requiring immediate attention.";
    }

    // SIZE BASED SIGNAL
    if ($size >= 5) {
        $insights[] = "Repeated pattern suggests systemic issue in '{$label}' operations.";
    }

    // DOMAIN RULES (your business logic layer)
    if (stripos($label, 'marketing') !== false) {
        $insights[] = "Marketing inefficiency cluster indicates opportunity in content strategy optimization.";
    }

    if (stripos($label, 'social') !== false) {
        $insights[] = "Social engagement gap suggests underutilized distribution channels.";
    }

    if (stripos($label, 'website') !== false) {
        $insights[] = "Website-related signals suggest conversion funnel weakness or UX friction.";
    }

    // DEFAULT INSIGHT
    if (empty($insights)) {
        $insights[] = "Cluster '{$label}' requires further analysis for actionable classification.";
    }

    return $insights;
}

/*
|--------------------------------------------------------------------------
| MAIN INSIGHT GENERATOR
|--------------------------------------------------------------------------
*/

function generateInsights($network_file) {

    $clusters = detectClusters($network_file);

    $allInsights = [];

    foreach ($clusters as $cluster) {

        $insights = generateInsightText($cluster);

        $allInsights[] = [
            "cluster" => $cluster['label'],
            "size" => $cluster['size'],
            "strength" => $cluster['strength'],
            "insights" => $insights
        ];
    }

    return $allInsights;
}