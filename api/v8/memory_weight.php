<?php
header('Content-Type: application/json');

$file = __DIR__ . "/../../data/memory/memory.json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$memory = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$weighted = [];

foreach ($memory as $m) {

    $text = strtolower($m['content'] ?? '');
    $weight = 1;

    if (strpos($text, 'risk') !== false) $weight += 2;
    if (strpos($text, 'growth') !== false) $weight += 2;
    if (strpos($text, 'failure') !== false) $weight += 3;

    $weighted[] = [
        "content"=>$m['content'],
        "weight"=>$weight
    ];
}

/* SORT MOST IMPORTANT MEMORY FIRST */
usort($weighted, fn($a,$b)=>$b['weight'] <=> $a['weight']);

echo json_encode([
    "memory"=>$weighted
]);
echo json_encode($response);
exit;
