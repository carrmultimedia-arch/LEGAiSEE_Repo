<?php

$dir = __DIR__ . "/sets/";
require_once __DIR__ . '/lib/semantic_diff_engine.php';
if (!is_dir($dir)) {
    echo json_encode([]);
    exit;
}

$files = scandir($dir);
$sets = [];

foreach ($files as $f) {
    if (strpos($f, ".json") !== false) {
        $sets[] = json_decode(file_get_contents($dir . $f), true);
    }
}

echo json_encode($sets);