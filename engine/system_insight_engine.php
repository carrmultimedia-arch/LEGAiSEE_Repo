<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| SYSTEM INSIGHT ENGINE (V1)
|--------------------------------------------------------------------------
| PURPOSE:
| - Convert cross-case patterns into actionable intelligence
| - Generate insights, risks, opportunities
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/cross_case_engine.php';

function system_insight_engine(): array
{
    $cross = cross_case_engine();

    if (($cross['status'] ?? '') !== 'ok') {
        return [
            'status' => 'error',
            'message' => 'cross_case_engine failed'
        ];
    }

    $signals = $cross['cross_case_signals'] ?? [];
    $patterns = $cross['pattern_clusters'] ?? [];
    $summary  = $cross['summary'] ?? [];

    $insights = [];
    $risks = [];
    $opportunities = [];
    $recommendations = [];

    /*
    |--------------------------------------------------------------------------
    | SIGNAL ANALYSIS (REPETITION = WEAK SIGNAL STRENGTH)
    |--------------------------------------------------------------------------
    */

    foreach ($signals as $signal => $cases) {

        $count = count($cases);

        if ($count >= 3) {
            $risks[] = [
                'type' => 'systemic_issue',
                'signal' => $signal,
                'severity' => 'high',
                'occurrences' => $count,
                'interpretation' => 'Repeated across multiple cases indicates systemic breakdown'
            ];
        } elseif ($count == 2) {
            $insights[] = [
                'type' => 'emerging_pattern',
                'signal' => $signal,
                'confidence' => 'medium',
                'note' => 'Recurring across cases'
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PATTERN ANALYSIS (ROOT HYPOTHESIS CLUSTERS)
    |--------------------------------------------------------------------------
    */

    foreach ($patterns as $pattern => $cases) {

        $count = count($cases);

        if ($count >= 2) {
            $opportunities[] = [
                'type' => 'repeatable_strategy',
                'pattern' => $pattern,
                'strength' => $count,
                'interpretation' => 'This pattern appears across multiple cases and may represent a reusable system-level strategy'
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SYSTEM-LEVEL META INSIGHTS
    |--------------------------------------------------------------------------
    */

    if (($summary['repeated_signals'] ?? 0) > 0) {
        $insights[] = [
            'type' => 'system_behavior',
            'message' => 'System is detecting recurring behavioral signals across cases',
            'meaning' => 'Data suggests structural rather than isolated issues'
        ];
    }

    if (($summary['pattern_clusters'] ?? 0) > 1) {
        $opportunities[] = [
            'type' => 'cross_case_compounding',
            'message' => 'Multiple pattern clusters detected',
            'meaning' => 'Opportunity to build standardized system playbooks'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACTION GENERATION
    |--------------------------------------------------------------------------
    */

    if (count($risks) > 0) {
        $recommendations[] = [
            'priority' => 'high',
            'action' => 'Stabilize recurring systemic issues before scaling content output',
            'reason' => 'Repeated signals detected across multiple cases'
        ];
    }

    if (count($opportunities) > 0) {
        $recommendations[] = [
            'priority' => 'medium',
            'action' => 'Convert repeated patterns into reusable content systems',
            'reason' => 'Cross-case pattern reuse potential detected'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FINAL INTELLIGENCE OUTPUT
    |--------------------------------------------------------------------------
    */

    return [
        'status' => 'ok',

        'meta' => [
            'cases_analyzed' => $summary['total_cases'] ?? 0,
            'signals_processed' => $summary['unique_signals'] ?? 0
        ],

        'insights' => $insights,
        'risks' => $risks,
        'opportunities' => $opportunities,
        'recommendations' => $recommendations
    ];
}