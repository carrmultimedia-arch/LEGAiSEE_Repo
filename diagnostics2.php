<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/kernel/db.php';
$pdo = kernel_db();

echo "REAL DATA CHECK\n================\n\n";

echo "TREE NODES (client id + name):\n";
print_r($pdo->query("SELECT id, name FROM tree_nodes")->fetchAll(PDO::FETCH_ASSOC));

echo "\nDISTINCT cases.status VALUES:\n";
print_r($pdo->query("SELECT DISTINCT status FROM cases")->fetchAll(PDO::FETCH_COLUMN));

echo "\nactivity_log row count: " . $pdo->query("SELECT COUNT(*) FROM activity_log")->fetchColumn() . "\n";
print_r($pdo->query("SELECT * FROM activity_log LIMIT 3")->fetchAll(PDO::FETCH_ASSOC));

echo "\naudit_logs row count: " . $pdo->query("SELECT COUNT(*) FROM audit_logs")->fetchColumn() . "\n";
print_r($pdo->query("SELECT * FROM audit_logs LIMIT 3")->fetchAll(PDO::FETCH_ASSOC));