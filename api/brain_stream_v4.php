<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? '';

$path = __DIR__ . "/../normalized/" . $file;

$content = file_get_contents($path);

/* SIMULATED STREAM CHUNKS */
$chunks = [
    "Parsing document structure...",
    "Extracting semantic clusters...",
    "Running cross-model inference...",
    "Detecting contradictions...",
    "Building intelligence graph..."
];

echo json_encode([
    "file"=>$file,
    "stream"=>$chunks,
    "final_note"=>"Stream complete. Synthesis available."
]);