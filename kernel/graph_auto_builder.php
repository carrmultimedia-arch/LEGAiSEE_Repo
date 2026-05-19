<?php

require_once __DIR__ . '/../db.php';

/*
|--------------------------------------------------------------------------
| GRAPH AUTO-BUILDER
|--------------------------------------------------------------------------
| Converts nodes into relationships (edges)
*/

function similarityScore($a, $b) {

    $a = strtolower($a);
    $b = strtolower($b);

    $score = 0;

    // shared keywords boost
    $keywords = ['marketing','sales','video','traffic','lead','social','instagram','website'];

    foreach ($keywords as $k) {
        if (strpos($a, $k) !== false && strpos($b, $k) !== false) {
            $score += 25;
        }
    }

    // basic text overlap
    similar_text($a, $b, $percent);
    $score += ($percent / 2);

    return min(100, $score);
}

function edgeType($score) {
    if ($score > 75) return "strong_relation";
    if ($score > 50) return "related";
    if ($score > 30) return "weak_relation";
    return null;
}

/*
|--------------------------------------------------------------------------
| BUILD GRAPH
|--------------------------------------------------------------------------
*/

function buildGraph($network_file) {

    if (!file_exists($network_file)) return false;

    $data = json_decode(file_get_contents($network_file), true);

    $nodes = $data['nodes'] ?? [];
    $edges = [];

    $count = count($nodes);

    for ($i = 0; $i < $count; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {

            $a = $nodes[$i];
            $b = $nodes[$j];

            $score = similarityScore($a['content'], $b['content']);
            $type = edgeType($score);

            if ($type !== null) {

                $edges[] = [
                    "from" => $a['id'],
                    "to" => $b['id'],
                    "type" => $type,
                    "strength" => $score
                ];
            }
        }
    }

    $data['edges'] = $edges;

    file_put_contents($network_file, json_encode($data, JSON_PRETTY_PRINT));

    return [
        "nodes" => $count,
        "edges" => count($edges)
    ];
}