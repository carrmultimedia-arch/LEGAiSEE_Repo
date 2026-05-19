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
| BUILD TRANSITION MATRIX
|--------------------------------------------------------------------------
| For every case, treat patterns as a sequence set
| and build A → B likelihood counts
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
| NORMALIZE TO PROBABILITIES
|--------------------------------------------------------------------------
*/

$probabilities = [];

foreach ($transitions as $a => $targets) {

    $total = $patternTotals[$a] ?? 1;

    foreach ($targets as $b => $count) {
        $probabilities[$a][$b] = round($count / $total, 3);
    }
}

/*
|--------------------------------------------------------------------------
| GENERATE CASE-LEVEL PREDICTIONS
|--------------------------------------------------------------------------
*/

$casePredictions = [];

foreach ($cases as $case) {

    $caseId = $case['id'] ?? null;
    if (!$caseId) continue;

    $patterns = $case['analysis']['patterns'] ?? [];
    if (!is_array($patterns)) $patterns = [];

    $scores = [];

    foreach ($patterns as $p) {

        if (!isset($probabilities[$p])) continue;

        foreach ($probabilities[$p] as $target => $prob) {

            if (!isset($scores[$target])) {
                $scores[$target] = 0;
            }

            $scores[$target] += $prob;
        }
    }

    // sort highest likelihood first
    arsort($scores);

    // remove already-present patterns
    foreach ($patterns as $p) {
        unset($scores[$p]);
    }

    $casePredictions[$caseId] = array_slice($scores, 0, 5, true);
}

/*
|--------------------------------------------------------------------------
| GLOBAL TOP PREDICTIONS
|--------------------------------------------------------------------------
*/

$globalScores = [];

foreach ($casePredictions as $preds) {
    foreach ($preds as $p => $score) {
        if (!isset($globalScores[$p])) {
            $globalScores[$p] = 0;
        }
        $globalScores[$p] += $score;
    }
}

arsort($globalScores);

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Predictive Engine',
    'type'  => 'analysis',

    'items' => [

        [
            'title' => 'Pattern Transition Probabilities',
            'meta'  => count($probabilities) . ' source patterns',
            'content' => json_encode($probabilities, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Case-Level Predictions',
            'meta'  => count($casePredictions) . ' cases',
            'content' => json_encode($casePredictions, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Global Predicted Patterns',
            'meta'  => count($globalScores) . ' signals',
            'content' => json_encode(array_slice($globalScores, 0, 10, true), JSON_PRETTY_PRINT)
        ]

    ]
];