<?php

require_once __DIR__ . '/utils/json_helpers.php';

/*
|--------------------------------------------------------------------------
| EXECUTIVE NARRATIVE STITCHING ENGINE
|--------------------------------------------------------------------------
| Artifacts → Signals → Clusters → Executive Case Narratives
|--------------------------------------------------------------------------
*/

$clientsRoot = __DIR__ . '/../data/clients';

$allArtifacts = [];
$clusters = [];

/*
|--------------------------------------------------------------------------
| LOAD ARTIFACTS
|--------------------------------------------------------------------------
*/

$clients = is_dir($clientsRoot) ? scandir($clientsRoot) : [];

require_once __DIR__ . '/../engine/entity_extraction_engine.php';
require_once __DIR__ . '/../kernel/db.php';
$db = kernel_db();
$extractionLog = [];

foreach ($clients as $cid) {

    if ($cid === '.' || $cid === '..') continue;

    // Load from case files (WO-C structure)
    $casesDir = $clientsRoot . "/$cid/cases";
    
    if (is_dir($casesDir)) {
        foreach (glob($casesDir . '/*/files/*') as $file) {
            if (!is_file($file)) continue;
            
            $rawText = file_get_contents($file);
            if (!$rawText) continue;
            
            $allArtifacts[] = [
                'client_id' => $cid,
                'file'      => basename($file),
                'text'      => strtolower($rawText),
                'timestamp' => date('c')
            ];
            
            // --- ENTITY EXTRACTION ---
            if ($db && strlen($rawText) > 5) {
                $extractionLog[] = lee_extract_and_store(
                    $db,
                    $rawText,
                    'case_file',
                    $cid,
                    basename($file)
                );
            }
        }
    }
    
    // Also load from legacy artifacts/metadata if exists
    $artifactDir = $clientsRoot . "/$cid/artifacts/metadata";
    if (is_dir($artifactDir)) {
        $files = scandir($artifactDir);

        foreach ($files as $file) {

            if (!str_ends_with($file, '.json')) continue;

            $meta = json_decode(
                file_get_contents($artifactDir . '/' . $file),
                true
            );

            if (!$meta) continue;

            // Read actual file content if available (not just filename)
            $rawText = $meta['file'] ?? '';
            if (!empty($meta['content'])) $rawText .= ' ' . $meta['content'];
            if (!empty($meta['summary'])) $rawText .= ' ' . $meta['summary'];
            if (!empty($meta['text']))    $rawText .= ' ' . $meta['text'];

            $allArtifacts[] = [
                'client_id' => $cid,
                'file'      => $meta['file'] ?? null,
                'text'      => strtolower($rawText),
                'timestamp' => $meta['created_at'] ?? date('c')
            ];

            // --- ENTITY EXTRACTION ---
            if ($db && strlen($rawText) > 5) {
                $extractionLog[] = lee_extract_and_store(
                    $db,
                    $rawText,
                    'artifact_metadata',
                    $cid,
                    $file
                );
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| SIGNAL EXTRACTION
|--------------------------------------------------------------------------
*/

function extractSignals($text){

    $signals = [];

    if (strpos($text, 'delay') !== false) $signals[] = 'ops_delay';
    if (strpos($text, 'late') !== false) $signals[] = 'ops_delay';

    if (strpos($text, 'price') !== false) $signals[] = 'pricing_pressure';
    if (strpos($text, 'cost') !== false) $signals[] = 'pricing_pressure';

    if (strpos($text, 'lead') !== false) $signals[] = 'lead_friction';
    if (strpos($text, 'conversion') !== false) $signals[] = 'lead_friction';

    if (strpos($text, 'staff') !== false) $signals[] = 'labor_issue';
    if (strpos($text, 'employee') !== false) $signals[] = 'labor_issue';

    return $signals;
}

/*
|--------------------------------------------------------------------------
| CLUSTERING
|--------------------------------------------------------------------------
*/

foreach ($allArtifacts as $a) {

    $signals = extractSignals($a['text']);

    foreach ($signals as $s) {

        if (!isset($clusters[$s])) {
            $clusters[$s] = [];
        }

        $clusters[$s][] = $a;
    }
}

/*
|--------------------------------------------------------------------------
| EXECUTIVE NARRATIVE GENERATOR
|--------------------------------------------------------------------------
*/

function buildNarrative($signal, $items){

    $count = count($items);
    $clients = array_unique(array_column($items, 'client_id'));

    $impactLevel = $count > 5 ? "HIGH" : ($count > 2 ? "MEDIUM" : "LOW");

    $clientSpread = count($clients);

    $summaryMap = [
        'ops_delay' =>
            "Operational delays are appearing across multiple artifacts, indicating process bottlenecks or execution friction in service delivery workflows.",

        'pricing_pressure' =>
            "Pricing-related signals suggest friction between perceived value and cost expectations, potentially impacting conversion or retention.",

        'lead_friction' =>
            "Lead generation or conversion breakdowns are present, indicating weakening funnel performance or messaging misalignment.",

        'labor_issue' =>
            "Staffing or workforce-related signals indicate internal execution strain that may be affecting consistency or delivery quality."
    ];

    $baseSummary = $summaryMap[$signal] ?? "Signal cluster detected across operational data.";

    $actions = [
        "Review top 3 contributing artifacts",
        "Audit funnel or operational step tied to signal",
        "Compare across affected clients for pattern consistency",
        "Prioritize root cause validation before scaling changes"
    ];

    return [
        'executive_summary' => $baseSummary,
        'impact_level' => $impactLevel,
        'signal' => $signal,
        'signal_strength' => $count,
        'client_span' => $clientSpread,

        'root_driver_hypothesis' =>
            "Cluster frequency and cross-client repetition suggest a systemic rather than isolated issue.",

        'recommended_actions' => $actions,

        'confidence_score' =>
            min(100, ($count * 15) + ($clientSpread * 10))
    ];
}

/*
|--------------------------------------------------------------------------
| BUILD AUTO CASES
|--------------------------------------------------------------------------
*/

$casesOutput = [];

foreach ($clusters as $signal => $items) {

    if (count($items) < 1) continue;

    $caseId = 'auto_case_' . $signal . '_' . time();

    $narrative = buildNarrative($signal, $items);

    $casesOutput[] = [
        'id' => $caseId,
        'type' => 'auto_executive_case',
        'status' => 'open',
        'created_at' => date('c'),

        /*
        |--------------------------------------------------------------------------
        | MULTI-ARTIFACT STITCHING
        |--------------------------------------------------------------------------
        */
        'artifacts' => $items,

        /*
        |--------------------------------------------------------------------------
        | ANALYTICS + SIGNAL LAYER
        |--------------------------------------------------------------------------
        */
        'analysis' => [
            'patterns' => [$signal],
            'signal_strength' => count($items),
            'client_span' => $narrative['client_span']
        ],

        /*
        |--------------------------------------------------------------------------
        | EXECUTIVE INTELLIGENCE LAYER (NEW CORE)
        |--------------------------------------------------------------------------
        */
        'executive' => $narrative
    ];
}

/*
|--------------------------------------------------------------------------
| OPTIONAL PERSISTENCE
|--------------------------------------------------------------------------
*/

foreach ($casesOutput as $case) {

    foreach ($case['artifacts'] as $a) {

        $dir = $clientsRoot . '/' . $a['client_id'] . '/cases';

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        file_put_contents(
            $dir . '/' . $case['id'] . '.json',
            json_encode($case, JSON_PRETTY_PRINT)
        );
    }
}

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

return [
    'title' => 'Executive Narrative Intelligence Engine',
    'type' => 'report',

    'items' => [

        [
            'title' => 'Clusters Detected',
            'meta' => count($clusters),
            'content' => json_encode(array_keys($clusters), JSON_PRETTY_PRINT)
        ],

        [
            'title' => 'Executive Cases Generated',
            'meta' => count($casesOutput),
            'content' => json_encode($casesOutput, JSON_PRETTY_PRINT)
        ],

        [
             'title'   => 'Entity Extraction Log',
               'meta'    => count($extractionLog) . ' artifacts processed',
              'content' => json_encode($extractionLog, JSON_PRETTY_PRINT)
        ],
    ]
];