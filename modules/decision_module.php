<?php

require_once __DIR__ . '/utils/bootstrap.php';

/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/

$cases = load_json_dir(__DIR__ . '/../data/cases');

/*
|--------------------------------------------------------------------------
| SIMPLE ACTION MAP (expand later)
|--------------------------------------------------------------------------
*/

$actionMap = [
    'delay'   => 'Investigate process bottleneck',
    'billing' => 'Audit billing workflow',
    'support' => 'Escalate customer support review',
    'quality' => 'Initiate QA review',
    'sales'   => 'Review sales process'
];

/*
|--------------------------------------------------------------------------
| BUILD PREDICTION MODEL (same logic as predictive module)
|--------------------------------------------------------------------------
*/

$transitions = [];
$patternTotals = [];

foreach ($cases as $case) {

    $patterns = $case['analysis']['patterns'] ?? [];

    if (!is_array($patterns) || count($patterns) < 2) {
        continue;
    }

    $unique = array_values(array_unique($patterns));
    $count = count($unique);

    for ($i = 0; $i < $count; $i++) {

        $a = $unique[$i];

        if (!isset($patternTotals[$a])) {
            $patternTotals[$a] = 0;
        }

        $patternTotals[$a]++;

        for ($j = 0; $j < $count; $j++) {

            if ($i === $j) continue;

            $b = $unique[$j];

            if (!isset($transitions[$a])) {
                $transitions[$a] = [];
            }

            if (!isset($transitions[$a][$b])) {
                $transitions[$a][$b] = 0;
            }

            $transitions[$a][$b]++;
        }
    }
}

/*
|--------------------------------------------------------------------------
| NORMALIZE
|--------------------------------------------------------------------------
*/

$probabilities = [];

foreach ($transitions as $a => $targets) {

    $total = $patternTotals[$a] ?? 1;

    foreach ($targets as $b => $count) {
        $probabilities[$a][$b] = $count / $total;
    }
}

/*
|--------------------------------------------------------------------------
| DECISION ENGINE
|--------------------------------------------------------------------------
*/

$decisions = [];

foreach ($cases as $case) {

    $caseId = $case['id'] ?? null;
    if (!$caseId) continue;

    $patterns = $case['analysis']['patterns'] ?? [];
    if (!is_array($patterns)) $patterns = [];

    $scores = [];

    /*
    | Predict next patterns
    */
    foreach ($patterns as $p) {

        if (!isset($probabilities[$p])) continue;

        foreach ($probabilities[$p] as $target => $prob) {

            if (!isset($scores[$target])) {
                $scores[$target] = 0;
            }

            $scores[$target] += $prob;
        }
    }

    /*
    | Remove already present
    */
    foreach ($patterns as $p) {
        unset($scores[$p]);
    }

    /*
    | Rank decisions
    */
    arsort($scores);

    $top = array_slice($scores, 0, 3, true);

    $recommendations = [];

    foreach ($top as $pattern => $score) {

        $recommendations[] = [
            'pattern' => $pattern,
            'confidence' => round($score, 3),
            'action' => $actionMap[$pattern] ?? 'No defined action'
        ];
    }

    /*
    | Priority score (simple heuristic)
    */
    $priority = 0;

    foreach ($top as $score) {
        $priority += $score;
    }

    $decisions[$caseId] = [
        'priority_score' => round($priority, 3),
        'recommendations' => $recommendations
    ];
}

/*
|--------------------------------------------------------------------------
| GLOBAL PRIORITIES
|--------------------------------------------------------------------------
*/

$global = [];

foreach ($decisions as $case) {
    foreach ($case['recommendations'] as $rec) {

        $p = $rec['pattern'];

        if (!isset($global[$p])) {
            $global[$p] = 0;
        }

        $global[$p] += $rec['confidence'];
    }
}

arsort($global);

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Decision Engine',
    'type'  => 'decision',

    'items' => [

        [
            'title' => 'Case Decisions',
            'meta'  => count($decisions) . ' cases',
            'content' => json_encode($decisions, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Global Priorities',
            'meta'  => count($global) . ' patterns',
            'content' => json_encode(array_slice($global, 0, 10, true), JSON_PRETTY_PRINT)
        ]

    ]
];