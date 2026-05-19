<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| DECISION ENGINE V2
|--------------------------------------------------------------------------
| PURPOSE:
| - Convert insights into structured decisions
| - Prepare actions for execution_router
| - NO execution allowed here
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/system_insight_engine.php';

function decision_engine_v2(): array
{
    $insight = system_insight_engine();

    if (($insight['status'] ?? '') !== 'ok') {
        return [
            'status' => 'error',
            'message' => 'insight engine failed'
        ];
    }

    $risks = $insight['risks'] ?? [];
    $opportunities = $insight['opportunities'] ?? [];
    $recommendations = $insight['recommendations'] ?? [];

    $decisions = [];
    $execution_queue = [];

    /*
    |--------------------------------------------------------------------------
    | 1. RISK-DRIVEN DECISIONS (STABILITY FIRST)
    |--------------------------------------------------------------------------
    */

    foreach ($risks as $risk) {

        $severity = $risk['severity'] ?? 'low';

        if ($severity === 'high') {

            $decisions[] = [
                'type' => 'stabilization',
                'priority' => 'critical',
                'action' => 'halt_nonessential_processing',
                'reason' => $risk['interpretation'] ?? 'Systemic risk detected',
                'signal' => $risk['signal'] ?? null
            ];

            $execution_queue[] = [
                'target' => 'execution_router',
                'command' => 'stabilize',
                'payload' => $risk
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 2. OPPORTUNITY-DRIVEN DECISIONS (GROWTH MODE)
    |--------------------------------------------------------------------------
    */

    foreach ($opportunities as $op) {

        $decisions[] = [
            'type' => 'optimization',
            'priority' => 'medium',
            'action' => 'convert_pattern_to_system',
            'pattern' => $op['pattern'] ?? null,
            'reason' => $op['interpretation'] ?? $op['message'] ?? 'Reusable pattern detected'
        ];

        $execution_queue[] = [
            'target' => 'execution_router',
            'command' => 'systemize_pattern',
            'payload' => $op
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 3. RECOMMENDATION TRANSLATION
    |--------------------------------------------------------------------------
    */

    foreach ($recommendations as $rec) {

        $priority = $rec['priority'] ?? 'low';

        $decisions[] = [
            'type' => 'strategic_action',
            'priority' => $priority,
            'action' => $rec['action'] ?? 'undefined_action',
            'reason' => $rec['reason'] ?? ''
        ];

        if ($priority === 'high') {
            $execution_queue[] = [
                'target' => 'execution_router',
                'command' => 'execute_priority_action',
                'payload' => $rec
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 4. SYSTEM STATE DECISION SUMMARY
    |--------------------------------------------------------------------------
    */

    $riskCount = count($risks);
    $oppCount = count($opportunities);

    $system_mode = 'stable';

    if ($riskCount > 0 && $oppCount === 0) {
        $system_mode = 'defensive';
    }

    if ($oppCount > 0 && $riskCount === 0) {
        $system_mode = 'growth';
    }

    if ($riskCount > 0 && $oppCount > 0) {
        $system_mode = 'balanced';
    }

    /*
    |--------------------------------------------------------------------------
    | FINAL DECISION OBJECT
    |--------------------------------------------------------------------------
    */

    return [
        'status' => 'ok',

        'system_mode' => $system_mode,

        'summary' => [
            'risks' => $riskCount,
            'opportunities' => $oppCount,
            'decisions_generated' => count($decisions)
        ],

        'decisions' => $decisions,

        'execution_queue' => $execution_queue
    ];
}