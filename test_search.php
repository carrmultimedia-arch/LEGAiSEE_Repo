<?php

$dir = __DIR__ . "/normalized/";
$metaFile = $dir . "index_meta.json";

if (!file_exists($metaFile)) {
    die("NO META INDEX");
}

$meta = json_decode(file_get_contents($metaFile), true);

echo "<h2>SEARCH INDEX TEST</h2>";
echo "Records: " . count($meta) . "<br><br>";

$sample = array_slice($meta, 0, 5);

foreach ($sample as $k => $m) {
    echo "✔ " . ($m['file'] ?? $k) . "<br>";
}