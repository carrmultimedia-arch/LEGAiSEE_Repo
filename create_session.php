<?php

// Accept JSON input
$data = json_decode(file_get_contents("php://input"), true);

$client = $data['client'] ?? null;
$query  = $data['query'] ?? null;

if (!$client || !$query) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing client or query"
    ]);
    exit;
}

// Clean client name
function clean($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9_\-]/', '_', $str);
    return preg_replace('/_+/', '_', $str);
}

$client = clean($client);

// Session ID (timestamp-based)
$session_id = date("Ymd_His");

// Base path
$baseDir = $_SERVER['DOCUMENT_ROOT'] . "/legaisee/clients/";

// Session path
$sessionPath = $baseDir . $client . "/excavations/" . $session_id . "/";

// Create folder structure
$folders = [
    $sessionPath,
    $sessionPath . "raw/",
    $sessionPath . "processed/",
    $sessionPath . "output/"
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// Session metadata
$sessionData = [
    "session_id" => $session_id,
    "client" => $client,
    "query" => $query,
    "status" => "created",
    "created_at" => date("Y-m-d H:i:s"),
    "platforms" => []
];

// Save session.json
file_put_contents(
    $sessionPath . "session.json",
    json_encode($sessionData, JSON_PRETTY_PRINT)
);

// RETURN CONTROL FLOW (IMPORTANT)
echo json_encode([
    "status" => "success",
    "session_id" => $session_id,
    "client" => $client,
    "redirect" => "session.php?session=" . $session_id . "&client=" . $client
]);

?>