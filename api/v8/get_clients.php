<?php

require_once __DIR__ . '/../../kernel/db.php';
require_once __DIR__ . '/../../response.php';

header('Content-Type: application/json');

try {
    $pdo = kernel_db();
    $stmt = $pdo->query("
        SELECT id, name, industry, website, created 
        FROM clients 
        ORDER BY name ASC
    ");
    json_response($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    json_error("Database error: " . $e->getMessage(), 500);
}