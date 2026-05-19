<?php
declare(strict_types=1);

/*
|------------------------------------------------------------
| CROSS CASE ENGINE (V1 - SCHEMA LOCKED)
|------------------------------------------------------------
| PURPOSE:
| - Build relational intelligence across cases + clients
| - Operates ONLY on /data JSON schema
| - No UI rendering
| - Returns structured array to shell layer
|------------------------------------------------------------
*/

$dataRoot = __DIR__ . '/../data';

$clientsPath = $dataRoot . '/clients';
$casesPath   = $dataRoot . '/cases';

/*
|------------------------------------------------------------
| SAFE JSON LOADER
|------------------------------------------------------------
*/
function load_json_files(string $dir): array
{
    $out = [];

    if (!is_dir($dir)) {
        return $out;
    }

    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . '/' . $file;

        if (!is_file($path)) continue;
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'json') continue;

        $json = json_decode(file_get_contents($path), true);

        if (is_array($json)) {
            $out[] = $json;
        }
    }

    return $out;
}

/*
|------------------------------------------------------------
| LOAD ENTITIES
|------------------------------------------------------------
*/
$clients = load_json_files($clientsPath);
$cases   = load_json_files($casesPath);

/*
|------------------------------------------------------------
| INDEX CLIENTS
|------------------------------------------------------------
*/
$clientIndex = [];

foreach ($clients as $c) {
    if (!isset($c['id'])) continue;
    $clientIndex[$c['id']] = $c;
}

/*
|------------------------------------------------------------
| CASE RELATION GRAPH
|------------------------------------------------------------
*/
$graph = [
    'client_case_map' => [],
    'shared_tags' => [],
    'industry_clusters' => [],
    'cross_case_links' => []
];

/*
|------------------------------------------------------------
| BUILD CLIENT → CASE MAP
|------------------------------------------------------------
*/
foreach ($cases as $case) {

    $clientId = $case['client_id'] ?? null;
    if (!$clientId) continue;

    if (!isset($graph['client_case_map'][$clientId])) {
        $graph['client_case_map'][$clientId] = [];
    }

    $graph['client_case_map'][$clientId][] = $case['id'] ?? 'unknown_case';
}

/*
|------------------------------------------------------------
| TAG + PATTERN ANALYSIS
|------------------------------------------------------------
*/
foreach ($cases as $caseA) {

    foreach ($cases as $caseB) {

        if (($caseA['id'] ?? null) === ($caseB['id'] ?? null)) {
            continue;
        }

        $tagsA = $caseA['analysis']['patterns'] ?? [];
        $tagsB = $caseB['analysis']['patterns'] ?? [];

        $shared = array_values(array_intersect($tagsA, $tagsB));

        if (!empty($shared)) {
            $graph['cross_case_links'][] = [
                'case_a' => $caseA['id'],
                'case_b' => $caseB['id'],
                'shared_patterns' => $shared,
                'strength' => count($shared)
            ];
        }
    }
}

/*
|------------------------------------------------------------
| INDUSTRY CLUSTERING (CLIENT LEVEL)
|------------------------------------------------------------
*/
foreach ($clients as $client) {

    $industry = $client['industry'] ?? 'unknown';

    if (!isset($graph['industry_clusters'][$industry])) {
        $graph['industry_clusters'][$industry] = [];
    }

    $graph['industry_clusters'][$industry][] = $client['id'];
}

/*
|------------------------------------------------------------
| OUTPUT STRUCTURE (FOR SHELL / BRAIN)
|------------------------------------------------------------
*/
return [
    'title' => 'Cross Case Engine',
    'type'  => 'inspector',

    'items' => [

        [
            'title' => 'Client → Case Map',
            'meta'  => count($graph['client_case_map']) . ' clients',
            'content' => json_encode($graph['client_case_map'], JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Industry Clusters',
            'meta'  => count($graph['industry_clusters']) . ' industries',
            'content' => json_encode($graph['industry_clusters'], JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Cross Case Links',
            'meta'  => count($graph['cross_case_links']) . ' relationships',
            'content' => json_encode($graph['cross_case_links'], JSON_PRETTY_PRINT)
        ]
    ],

    'raw_graph' => $graph
];