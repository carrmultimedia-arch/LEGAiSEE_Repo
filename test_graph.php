<?php

$file = __DIR__ . "/data/graph_data.php";

if (!file_exists($file)) {
    die("GRAPH API MISSING");
}

$data = json_decode(file_get_contents("http://localhost/commandcenter/data/graph_data.php"), true);

echo "<h2>GRAPH TEST</h2>";

echo "Nodes: " . count($data['nodes'] ?? []) . "<br>";
echo "Links: " . count($data['links'] ?? []) . "<br>";