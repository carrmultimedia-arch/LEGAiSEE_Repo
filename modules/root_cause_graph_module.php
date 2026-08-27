<?php

require_once __DIR__ . '/utils/bootstrap.php';

$cases = load_json_dir(__DIR__ . '/../data/cases');

$case_id = $_GET['case_id'] ?? null;

$nodes = [];
$edgeMap = [];

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

function add_node(&$nodes, $id, $label, $type) {
    if (!isset($nodes[$id])) {
        $nodes[$id] = [
            'id' => $id,
            'label' => $label,
            'type' => $type,
            'degree' => 0
        ];
    }
}

function add_edge(&$edgeMap, $from, $to) {

    $key = $from . '|' . $to;

    if (!isset($edgeMap[$key])) {
        $edgeMap[$key] = [
            'from' => $from,
            'to'   => $to,
            'weight' => 0
        ];
    }

    $edgeMap[$key]['weight']++;
}

/*
|--------------------------------------------------------------------------
| BUILD GRAPH
|--------------------------------------------------------------------------
*/

foreach ($cases as $c) {

    $caseId = $c['id'] ?? uniqid('case_');
    $cid    = $c['client_id'] ?? null;

    add_node($nodes, $caseId, $caseId, 'case');

    if ($cid) {
        add_node($nodes, $cid, $cid, 'client');
        add_edge($edgeMap, $caseId, $cid);
    }

    $patterns = $c['analysis']['patterns'] ?? [];

    if (is_array($patterns)) {

        foreach ($patterns as $p) {

            $pid = 'pattern_' . $p;

            add_node($nodes, $pid, $p, 'pattern');
            add_edge($edgeMap, $caseId, $pid);
        }

        // pattern co-occurrence (drives clustering)
        for ($i=0; $i<count($patterns); $i++) {
            for ($j=$i+1; $j<count($patterns); $j++) {

                $p1 = 'pattern_' . $patterns[$i];
                $p2 = 'pattern_' . $patterns[$j];

                add_edge($edgeMap, $p1, $p2);
                add_edge($edgeMap, $p2, $p1);
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| DEGREE CALCULATION
|--------------------------------------------------------------------------
*/

foreach ($edgeMap as $e) {
    if (isset($nodes[$e['from']])) $nodes[$e['from']]['degree']++;
    if (isset($nodes[$e['to']]))   $nodes[$e['to']]['degree']++;
}

/*
|--------------------------------------------------------------------------
| WRITE NETWORK TO CASE FILE
|--------------------------------------------------------------------------
*/

function writeNetwork(array $nodes, array $edges, string $case_id): bool {
    if (!$case_id) return false;
    
    // Find case directory
    $caseDir = null;
    $clientsDir = __DIR__ . '/../data/clients';
    
    foreach (glob($clientsDir . '/*/cases/*', GLOB_ONLYDIR) as $dir) {
        if (basename($dir) === $case_id) {
            $caseDir = $dir;
            break;
        }
    }
    
    if (!$caseDir) return false;
    
    $networkFile = $caseDir . '/network.json';
    
    // Convert to schema format
    $schemaNodes = [];
    foreach ($nodes as $node) {
        $schemaNodes[] = [
            'id' => $node['id'],
            'type' => $node['type'],
            'strength' => 100,
            'content' => $node['label'],
            'created_at' => date('c')
        ];
    }
    
    $schemaEdges = [];
    foreach ($edges as $edge) {
        $schemaEdges[] = [
            'from' => $edge['from'],
            'to' => $edge['to'],
            'weight' => $edge['weight']
        ];
    }
    
    $networkData = [
        'nodes' => $schemaNodes,
        'edges' => $schemaEdges
    ];
    
    return file_put_contents($networkFile, json_encode($networkData, JSON_PRETTY_PRINT)) !== false;
}

// Write network if case_id provided
if ($case_id && !empty($nodes)) {
    writeNetwork($nodes, array_values($edgeMap), $case_id);
}

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Root Cause Graph (Clustered Sandbox)',
    'type'  => 'graph',
    'items' => [
        [
            'title' => 'Graph Data',
            'meta'  => count($nodes) . ' nodes',
            'content' => json_encode([
                'nodes' => array_values($nodes),
                'edges' => array_values($edgeMap)
            ])
        ]
    ]
];