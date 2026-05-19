<?php

require_once __DIR__ . '/utils/bootstrap.php';

$cases = load_json_dir(__DIR__ . '/../data/cases');

/*
|--------------------------------------------------------------------------
| TIME BUCKETS
|--------------------------------------------------------------------------
*/

$now = time();
$windows = [
    '7d'  => strtotime('-7 days'),
    '30d' => strtotime('-30 days')
];

$buckets = [
    '7d'  => [],
    '30d' => []
];

/*
|--------------------------------------------------------------------------
| SORT INTO TIME WINDOWS
|--------------------------------------------------------------------------
*/

foreach ($cases as $case) {

    if (!isset($case['created_at'])) continue;

    $ts = strtotime($case['created_at']);
    if (!$ts) continue;

    foreach ($windows as $key => $cutoff) {

        if ($ts >= $cutoff) {

            $patterns = $case['analysis']['patterns'] ?? [];

            if (!is_array($patterns)) continue;

            foreach ($patterns as $p) {

                if (!isset($buckets[$key][$p])) {
                    $buckets[$key][$p] = 0;
                }

                $buckets[$key][$p]++;
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| TREND CALCULATION
|--------------------------------------------------------------------------
*/

$trends = [];

$allPatterns = array_unique(array_merge(
    array_keys($buckets['7d']),
    array_keys($buckets['30d'])
));

foreach ($allPatterns as $p) {

    $v7  = $buckets['7d'][$p]  ?? 0;
    $v30 = $buckets['30d'][$p] ?? 0;

    $baseline = $v30 > 0 ? $v30 / 4 : 0; // normalize 30d to weekly

    $delta = $v7 - $baseline;

    $trend = 'stable';

    if ($delta > 1) $trend = 'rising';
    if ($delta < -1) $trend = 'declining';

    $trends[$p] = [
        'last_7d'  => $v7,
        'baseline' => round($baseline,2),
        'delta'    => round($delta,2),
        'trend'    => $trend
    ];
}

/*
|--------------------------------------------------------------------------
| SORT BY MOVEMENT
|--------------------------------------------------------------------------
*/

uasort($trends, function($a, $b) {
    return abs($b['delta']) <=> abs($a['delta']);
});

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Time Intelligence',
    'type'  => 'temporal',

    'items' => [

        [
            'title' => 'Trend Analysis',
            'meta'  => '7d vs 30d baseline',
            'content' => json_encode($trends, JSON_PRETTY_PRINT)
        ]

    ]
];