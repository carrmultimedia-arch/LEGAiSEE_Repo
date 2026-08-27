<?php

require_once __DIR__ . '/../../kernel/db.php';
require_once __DIR__ . '/../../response.php';

$case_id = $_GET['case_id'] ?? null;

if (empty($case_id)) {
    json_error("case_id is required.", 400);
    exit;
}

try {
    $pdo = kernel_db();
    $stmt = $pdo->prepare("
        SELECT canonical_name, entity_type, confidence, strength
        FROM entities
        WHERE context = ? ORDER BY strength DESC, confidence DESC LIMIT 10
    ");
    $stmt->execute([$case_id]);
    json_response(['top_nodes' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
} catch (Exception $e) {
    json_error("Database error: " . $e->getMessage(), 500);
}