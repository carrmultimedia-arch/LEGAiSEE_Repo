<?php

header('Content-Type: application/json');

$base = __DIR__ . "/clients/";
$normalized = __DIR__ . "/normalized/";
$metaFile = $normalized . "index_meta.json";
require_once __DIR__ . '/lib/semantic_diff_engine.php';

if (!is_dir($normalized)) {
    mkdir($normalized, 0777, true);
}

$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true) ?: []
    : [];

function score($text) {
    return strlen($text) / 100;
}

/* FLAT RECURSIVE SCAN - NO STRUCTURE ASSUMPTIONS */
function scanAllFiles($dir) {

    $out = [];

    if (!is_dir($dir)) return $out;

    foreach (scandir($dir) as $item) {

        if ($item === '.' || $item === '..') continue;

        $path = $dir . "/" . $item;

        if (is_dir($path)) {
            $out = array_merge($out, scanAllFiles($path));
        } else {
            $out[] = $path;
        }
    }

    return $out;
}

$files = scanAllFiles($base);

$indexed = 0;

foreach ($files as $file) {

    $content = file_get_contents($file);

    if (!$content || strlen(trim($content)) === 0) continue;

    /* derive simple client label from top folder */
    $relative = str_replace($base, "", $file);
    $parts = explode("/", $relative);
    $client = $parts[0] ?? "unknown";

    $key = md5($file) . ".txt";

    file_put_contents($normalized . $key, $content);

    $meta[$key] = [
        "client" => $client,
        "file" => $file,
        "score" => score($content),
        "length" => strlen($content),
        "updated" => date("Y-m-d H:i:s")
    ];

    $indexed++;
}

file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT));

echo json_encode([
    "success" => true,
    "indexed" => $indexed,
    "meta" => count($meta)
]);