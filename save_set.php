<?php

$data = json_decode(file_get_contents("php://input"), true);
require_once __DIR__ . '/lib/semantic_diff_engine.php';
if (!$data) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$name     = $data['name'] ?? "";
$query    = $data['query'] ?? "";
$system   = $data['system'] ?? "";
$platform = $data['platform'] ?? "";
$client   = $data['client'] ?? "";

if (!$name) {
    echo json_encode(["error" => "Set name required"]);
    exit;
}

$safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', strtolower($name));

$dir = __DIR__ . "/sets/";
if (!is_dir($dir)) mkdir($dir, 0777, true);

$file = $dir . "set_" . $safeName . ".json";

$payload = [
    "name" => $name,
    "query" => $query,
    "system" => $system,
    "platform" => $platform,
    "client" => $client,
    "created" => date("Y-m-d H:i:s")
];

file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "file" => basename($file)]);