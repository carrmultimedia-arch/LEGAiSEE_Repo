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
| BUILD CLIENT INDEX
|--------------------------------------------------------------------------
*/

$clientIndex = [];

foreach ($clients as $c) {
    if (!isset($c['id'])) continue;
    $clientIndex[$c['id']] = $c;
}

/*
|--------------------------------------------------------------------------
| RELATIONSHIP STRUCTURES
|--------------------------------------------------------------------------
*/

$caseToClient   = [];
$caseToPatterns = [];
$patternLinks   = [];   // co-occurrence graph
$clientToCases  = [];

/*
|--------------------------------------------------------------------------
| PROCESS CASES
|--------------------------------------------------------------------------
*/

foreach ($cases as $case) {

    $caseId = $case['id'] ?? null;
    if (!$caseId) continue;

    $clientId = $case['client_id'] ?? 'unknown';
    $patterns = $case['analysis']['patterns'] ?? [];

    if (!is_array($patterns)) {
        $patterns = [];
    }

    /*
    | CASE → CLIENT
    */
    $caseToClient[$caseId] = $clientId;

    /*
    | CLIENT → CASES
    */
    if (!isset($clientToCases[$clientId])) {
        $clientToCases[$clientId] = [];
    }
    $clientToCases[$clientId][] = $caseId;

    /*
    | CASE → PATTERNS
    */
    $caseToPatterns[$caseId] = $patterns;

    /*
    | PATTERN CO-OCCURRENCE GRAPH
    */
    $count = count($patterns);

    for ($i = 0; $i < $count; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {

            $a = $patterns[$i];
            $b = $patterns[$j];

            if (!isset($patternLinks[$a])) {
                $patternLinks[$a] = [];
            }

            if (!isset($patternLinks[$a][$b])) {
                $patternLinks[$a][$b] = 0;
            }

            $patternLinks[$a][$b]++;

            // mirror link
            if (!isset($patternLinks[$b])) {
                $patternLinks[$b] = [];
            }

            if (!isset($patternLinks[$b][$a])) {
                $patternLinks[$b][$a] = 0;
            }

            $patternLinks[$b][$a]++;
        }
    }
}

/*
|--------------------------------------------------------------------------
| FORMAT OUTPUT
|--------------------------------------------------------------------------
*/

$clientSummary = [];

foreach ($clientToCases as $cid => $caseIds) {
    $clientSummary[] = [
        'client_id'   => $cid,
        'client_name' => $clientIndex[$cid]['name'] ?? 'Unknown',
        'case_count'  => count($caseIds)
    ];
}

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Relationship Engine',
    'type'  => 'graph',

    'items' => [

        [
            'title' => 'Case → Client Map',
            'meta'  => count($caseToClient) . ' links',
            'content' => json_encode($caseToClient, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Client → Case Distribution',
            'meta'  => count($clientSummary) . ' clients',
            'content' => json_encode($clientSummary, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Case → Pattern Map',
            'meta'  => count($caseToPatterns) . ' cases',
            'content' => json_encode($caseToPatterns, JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Pattern Co-Occurrence Graph',
            'meta'  => count($patternLinks) . ' nodes',
            'content' => json_encode($patternLinks, JSON_PRETTY_PRINT)
        ]

    ]
];