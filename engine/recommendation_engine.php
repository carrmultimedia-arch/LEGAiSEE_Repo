<?php

/**
 * recommendation_engine.php
 * Converts insights into specific recommended actions.
 * Reads insights.json, produces recommendations.json
 */

function generate_recommendations_for_case(string $case_id): array
{
    if (empty($case_id)) {
        throw new InvalidArgumentException("Case ID cannot be empty.");
    }

    $caseDir = __DIR__ . "/../data/cases/{$case_id}/";
    $insightFile = $caseDir . "insights.json";
    $outputFile = $caseDir . "recommendations.json";

    if (!file_exists($insightFile)) {
        return ['status' => 'error', 'message' => 'insights.json not found for case.'];
    }

    $insights = json_decode(file_get_contents($insightFile), true);
    if (!is_array($insights)) {
        return ['status' => 'error', 'message' => 'Invalid insights.json format.'];
    }

    $recommendations = [];

    foreach ($insights as $insight) {
        if (($insight['type'] ?? '') === 'risk_vs_growth') {
            $recommendations[] = ['title' => 'Resolve Strategic Conflict', 'action' => 'Prioritize risk mitigation before pursuing linked growth opportunities.', 'priority' => 'high'];
        }
        if (($insight['type'] ?? '') === 'clean_opportunity') {
            $recommendations[] = ['title' => 'Explore Clean Opportunity', 'action' => 'Develop action plan for low-risk opportunity.', 'priority' => 'medium'];
        }
    }

    file_put_contents($outputFile, json_encode($recommendations, JSON_PRETTY_PRINT));

    return [
        'status' => 'ok',
        'recommendation_count' => count($recommendations),
        'recommendations' => $recommendations
    ];
}