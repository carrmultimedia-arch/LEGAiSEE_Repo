<?php
require_once __DIR__ . "/kernel/kernel.php";

$pdo = kernel_db();

if (!$pdo) {
    die("KERNEL FAIL: No DB connection");
}

echo "KERNEL OK\n";

echo "Pages: " . $pdo->query("SELECT COUNT(*) FROM page")->fetchColumn() . "\n";
echo "Clusters: " . $pdo->query("SELECT COUNT(*) FROM clusters")->fetchColumn() . "\n";