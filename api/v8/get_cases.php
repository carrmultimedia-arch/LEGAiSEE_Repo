<?php

require_once __DIR__ . '/../../kernel/db.php';
require_once __DIR__ . '/../../response.php';

header('Content-Type: application/json');

$client_id = $_GET['client_id'] ?? null;

if (empty($client_id)) {
    json_error("client_id is required.", 400);
    exit;
}

try {
    $pdo = kernel_db();
    $stmt = $pdo->prepare("
        SELECT id, client_id, case_id, status, created_at 
        FROM cases 
        WHERE client_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$client_id]);
    json_response($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    json_error("Database error: " . $e->getMessage(), 500);
}