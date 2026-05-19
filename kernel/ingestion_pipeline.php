<?php

require_once __DIR__ . '/../db.php';

/*
|--------------------------------------------------------------------------
| INGESTION → NODE PIPELINE
|--------------------------------------------------------------------------
| Converts raw text into structured intelligence nodes
*/

function generateNodeId() {
    return uniqid("node_", true);
}

function analyzeStrength($text) {
    // simple heuristic scoring (upgrade later with AI)
    $score = 50;

    if (strlen($text) > 100) $score += 10;
    if (strpos(strtolower($text), 'urgent') !== false) $score += 20;
    if (strpos(strtolower($text), 'opportunity') !== false) $score += 15;

    return min(100, $score);
}

function classifyType($text) {
    $text = strtolower($text);

    if (strpos($text, 'problem') !== false) return 'anomaly';
    if (strpos($text, 'opportunity') !== false) return 'signal';
    if (strpos($text, 'competitor') !== false) return 'signal';

    return 'note';
}

function extractTags($text) {
    $tags = [];

    if (stripos($text, 'marketing') !== false) $tags[] = 'marketing';
    if (stripos($text, 'video') !== false) $tags[] = 'video';
    if (stripos($text, 'sales') !== false) $tags[] = 'sales';
    if (stripos($text, 'website') !== false) $tags[] = 'web';

    return $tags;
}

/*
|--------------------------------------------------------------------------
| MAIN PIPELINE FUNCTION
|--------------------------------------------------------------------------
*/

function ingestToNode($case_id, $text, $network_file) {

    $node = [
        "id" => generateNodeId(),
        "case_id" => $case_id,
        "type" => classifyType($text),
        "content" => $text,
        "strength" => analyzeStrength($text),
        "tags" => extractTags($text),
        "created_at" => date("Y-m-d H:i:s")
    ];

    // LOAD NETWORK
    if (!file_exists($network_file)) {
        file_put_contents($network_file, json_encode(["nodes"=>[], "edges"=>[]]));
    }

    $data = json_decode(file_get_contents($network_file), true);

    // ADD NODE
    $data['nodes'][] = $node;

    // SAVE BACK
    file_put_contents($network_file, json_encode($data, JSON_PRETTY_PRINT));

    return $node;
}