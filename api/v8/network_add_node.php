<?php
session_start();
require_once __DIR__ . '/../../kernel/db.php';
require_once __DIR__ . '/../../response.php';

// 🔹 Get input
$input = json_decode(file_get_contents('php://input'), true);

// 🔹 Get Identity from Session
$node_id = $_SESSION['brain_node_id'] ?? null;

// 🔹 Get Payload Data
$content = $input['content'] ?? null;
$type = $input['type'] ?? 'note';
$name = $input['name'] ?? 'New Node';

// 🔹 Validate input
if (empty($content)) {
    json_error("Content is required.", 400);
    exit;
}

if (empty($node_id)) {
    json_error("Node ID (from session) is required for identity.", 400);
    exit;
}

try {
    $pdo = kernel_db();

    // 🔹 Insert the new node as a child of the session's node
    $stmt = $pdo->prepare("
        INSERT INTO tree_nodes (parent_id, name, type, metadata) 
        VALUES (?, ?, ?, ?)
    ");
    $metadata = json_encode(['content' => $content]);
    $stmt->execute([$node_id, $name, $type, $metadata]);

    $new_node_id = $pdo->lastInsertId();

    json_response(['id' => $new_node_id, 'parent_id' => $node_id]);
} catch (Exception $e) {
    json_error("Database error: " . $e->getMessage(), 500);
}