<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/kernel/db.php';

try {
    $pdo = kernel_db();
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS review_flags (
            id           INT PRIMARY KEY AUTO_INCREMENT,
            source_table VARCHAR(100) NOT NULL,
            source_id    INTEGER NOT NULL,
            context      TEXT DEFAULT NULL,
            status       VARCHAR(50) NOT NULL DEFAULT 'pending',
            operator_note TEXT DEFAULT NULL,
            reviewed_at  DATETIME NULL,
            created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "review_flags table created successfully.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}