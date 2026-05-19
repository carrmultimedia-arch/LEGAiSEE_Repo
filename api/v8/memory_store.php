<?php
header('Content-Type: application/json');

$content = $_POST['content'] ?? '';
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

if (!$content) {
    echo json_encode(["error"=>"no content"]);
    exit;
}

$file = __DIR__ . "/../../data/memory/memory.json";

$data = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$data[] = [
    "content"=>$content,
    "timestamp"=>date("Y-m-d H:i:s")
];

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(["success"=>true]);
echo json_encode($response);
exit;
