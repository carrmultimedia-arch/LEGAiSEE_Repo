<?php

require_once __DIR__ . '/utils/bootstrap.php';

/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/

$cases   = load_json_dir(__DIR__ . '/../data/cases');
$clients = load_json_dir(__DIR__ . '/../data/clients');

/*
|--------------------------------------------------------------------------
| BASIC METRICS
|--------------------------------------------------------------------------
*/

$totalCases   = count($cases);
$totalClients = count($clients);

/*
|--------------------------------------------------------------------------
| STATUS DISTRIBUTION
|--------------------------------------------------------------------------
*/

$statusMap = [];

foreach ($cases as $case) {
    $status = $case['status'] ?? 'unknown';

    if (!isset($statusMap[$status])) {
        $statusMap[$status] = 0;
    }

    $statusMap[$status]++;
}

/*
|--------------------------------------------------------------------------
| PATTERN FREQUENCY
|--------------------------------------------------------------------------
*/

$patternFreq = [];

foreach ($cases as $case) {

    $patterns = $case['analysis']['patterns'] ?? [];
    if (!is_array($patterns)) continue;

    foreach ($patterns as $p) {

        if (!isset($patternFreq[$p])) {
            $patternFreq[$p] = 0;
        }

        $patternFreq[$p]++;
    }
}

arsort($patternFreq);

/*
|--------------------------------------------------------------------------
| SIMPLE DECISION SIGNALS (reuse logic)
|--------------------------------------------------------------------------
*/

$transitions = [];
$patternTotals = [];

foreach ($cases as $case) {

    $patterns = $case['analysis']['patterns'] ?? [];
    if (!is_array($patterns) || count($patterns) < 2) continue;

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
| PROBABILITIES
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
| GLOBAL PRIORITIES
|--------------------------------------------------------------------------
*/

$globalScores = [];

foreach ($cases as $case) {

    $patterns = $case['analysis']['patterns'] ?? [];
    if (!is_array($patterns)) continue;

    foreach ($patterns as $p) {

        if (!isset($probabilities[$p])) continue;

        foreach ($probabilities[$p] as $target => $prob) {

            if (!isset($globalScores[$target])) {
                $globalScores[$target] = 0;
            }

            $globalScores[$target] += $prob;
        }
    }
}

arsort($globalScores);

/*
|--------------------------------------------------------------------------
| TOP RISKS
|--------------------------------------------------------------------------
*/

$topRisks = array_slice($globalScores, 0, 5, true);

/*
|--------------------------------------------------------------------------
| SYSTEM HEALTH
|--------------------------------------------------------------------------
*/

$health = [
    'cases_loaded'   => $totalCases,
    'clients_loaded' => $totalClients,
    'data_quality'   => $totalCases > 0 ? 'OK' : 'NO DATA',
    'engine_state'   => 'ACTIVE'
];

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Executive Dashboard',
    'type'  => 'executive',

    'items' => [

        [
            'title' => 'System Overview',
            'meta'  => 'Live Snapshot',
            'content' => json_encode([
                'total_cases'   => $totalCases,
                'total_clients' => $totalClients,
                'status_distribution' => $statusMap
            ], JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Top Risk Patterns',
            'meta'  => 'Highest predicted impact',
            'content' => json_encode($topRisks, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Pattern Frequency',
            'meta'  => 'Observed occurrences',
            'content' => json_encode(array_slice($patternFreq, 0, 10, true), JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'System Health',
            'meta'  => 'Runtime status',
            'content' => json_encode($health, JSON_PRETTY_PRINT)
        ]

    ]
];