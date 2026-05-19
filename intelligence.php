<?php

/*
=====================================================
LEGAiSEE INTELLIGENCE ENGINE v1 (LOCAL)
=====================================================
- No API dependencies
- Rule-based extraction
- Outputs structured JSON next to source file
=====================================================
*/
require_once __DIR__ . '/lib/semantic_diff_engine.php';
if (!isset($_GET['file'])) {
    die("No file specified");
}

$baseDir = __DIR__ . "/normalized/";
$file = basename($_GET['file']);

$path = realpath($baseDir . $file);

if (!$path || strpos($path, $baseDir) !== 0 || !file_exists($path)) {
    die("Invalid file");
}

$content = file_get_contents($path);
$lines = explode("\n", strtolower($content));

$insights = [];
$actions = [];
$assets = [];
$entities = [];
$keywords = [];

/*
=====================================================
1. ENTITY DETECTION (basic known taxonomy)
=====================================================
*/

$knownEntities = [
    "chatgpt", "gpt", "claude", "gemini", "kimi",
    "openai", "anthropic", "google"
];

foreach ($knownEntities as $e) {
    if (stripos($content, $e) !== false) {
        $entities[] = $e;
    }
}

/*
=====================================================
2. RULE-BASED SENTENCE CLASSIFICATION
=====================================================
*/

foreach ($lines as $line) {

    $line = trim($line);
    if (strlen($line) < 4) continue;

    // ACTION DETECTION
    if (
        str_contains($line, "need to") ||
        str_contains($line, "should") ||
        str_contains($line, "must") ||
        str_contains($line, "going to") ||
        str_contains($line, "will build") ||
        str_contains($line, "we will")
    ) {
        $actions[] = $line;
    }

    // INSIGHT DETECTION
    if (
        str_contains($line, "problem") ||
        str_contains($line, "issue") ||
        str_contains($line, "bottleneck") ||
        str_contains($line, "confusing") ||
        str_contains($line, "important") ||
        str_contains($line, "realization")
    ) {
        $insights[] = $line;
    }

    // ASSET DETECTION
    if (
        str_contains($line, "template") ||
        str_contains($line, "framework") ||
        str_contains($line, "use this") ||
        str_contains($line, "copy") ||
        str_contains($line, "reusable") ||
        str_contains($line, "system")
    ) {
        $assets[] = $line;
    }

    /*
    =====================================================
    3. KEYWORD EXTRACTION (simple frequency model)
    =====================================================
    */

    $words = preg_split('/\s+/', preg_replace('/[^a-z0-9 ]/', '', $line));

    foreach ($words as $w) {
        if (strlen($w) < 4) continue;

        if (!isset($keywords[$w])) {
            $keywords[$w] = 0;
        }
        $keywords[$w]++;
    }
}

/*
=====================================================
4. SORT KEYWORDS BY FREQUENCY
=====================================================
*/

arsort($keywords);

/*
=====================================================
5. FINAL STRUCTURE
=====================================================
*/

$output = [
    "file" => $file,
    "insights" => array_values(array_unique($insights)),
    "actions" => array_values(array_unique($actions)),
    "assets" => array_values(array_unique($assets)),
    "entities" => array_values(array_unique($entities)),
    "keywords" => array_slice(array_keys($keywords), 0, 30)
];

$jsonFile = $path . ".intelligence.json";

file_put_contents($jsonFile, json_encode($output, JSON_PRETTY_PRINT));

echo "INTELLIGENCE GENERATED FOR: " . $file;

?>