<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| CROSS CASE ENGINE (V1)
|--------------------------------------------------------------------------
| PURPOSE:
| - Analyze all case JSON files
| - Extract shared signals + patterns
| - Build cross-case intelligence map
|--------------------------------------------------------------------------
*/

function cross_case_engine(): array
{
    $base = realpath(__DIR__ . '/../data/cases');

    if (!$base || !is_dir($base)) {
        return [
            'status' => 'error',
            'message' => 'cases directory not found'
        ];
    }

    $files = scandir($base);

    $cases = [];

    /*
    |--------------------------------------------------------------------------
    | LOAD CASES
    |--------------------------------------------------------------------------
    */

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $base . '/' . $file;

        if (!is_file($path)) continue;

        $raw = file_get_contents($path);
        $json = json_decode($raw, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
            $cases[] = $json;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SIGNAL INDEXING
    |--------------------------------------------------------------------------
    */

    $signalIndex = [];
    $clientIndex = [];
    $patternBuckets = [];

    foreach ($cases as $case) {

        $caseId = $case['id'] ?? 'unknown';

        // CLIENT RELATIONSHIP MAP
        if (!empty($case['client_id'])) {
            $clientIndex[$case['client_id']][] = $caseId;
        }

        // SIGNAL EXTRACTION
        if (!empty($case['signals']) && is_array($case['signals'])) {

            foreach ($case['signals'] as $signal) {

                $normalized = strtolower(trim($signal));

                if (!isset($signalIndex[$normalized])) {
                    $signalIndex[$normalized] = [];
                }

                $signalIndex[$normalized][] = $caseId;
            }
        }

        // ROOT HYPOTHESIS CLUSTERING
        if (!empty($case['analysis']['root_hypotheses'])) {

            foreach ($case['analysis']['root_hypotheses'] as $hypothesis) {

                $key = strtolower(trim($hypothesis));

                if (!isset($patternBuckets[$key])) {
                    $patternBuckets[$key] = [];
                }

                $patternBuckets[$key][] = $caseId;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRACT CROSS-CASE PATTERNS
    |--------------------------------------------------------------------------
    */

    $repeatedSignals = array_filter($signalIndex, function ($cases) {
        return count($cases) > 1;
    });

    $strongPatterns = array_filter($patternBuckets, function ($cases) {
        return count($cases) > 1;
    });

    /*
    |--------------------------------------------------------------------------
    | OUTPUT INTELLIGENCE OBJECT
    |--------------------------------------------------------------------------
    */

    return [
        'status' => 'ok',

        'summary' => [
            'total_cases' => count($cases),
            'unique_signals' => count($signalIndex),
            'repeated_signals' => count($repeatedSignals),
            'pattern_clusters' => count($strongPatterns),
            'clients_mapped' => count($clientIndex)
        ],

        'cross_case_signals' => $repeatedSignals,

        'pattern_clusters' => $strongPatterns,

        'client_case_map' => $clientIndex,

        'insight_flags' => [
            'high_repetition_detected' => count($repeatedSignals) > 0,
            'emerging_patterns_detected' => count($strongPatterns) > 0
        ]
    ];
}