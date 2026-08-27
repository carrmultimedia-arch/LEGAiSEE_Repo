<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/kernel/db.php';

echo "LEGAiSEE DATABASE CONNECTION VERIFICATION\n";
echo "=========================================\n\n";

try {
    $pdo = kernel_db();
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "[OK] Connected successfully.\n";
    echo "Driver in use: " . $driver . "\n\n";

    echo "TABLES FOUND:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    print_r($tables);
    echo "\n";

    echo "RECORD COUNTS:\n";
    $checkTables = ['clients', 'cases', 'tree_nodes'];
    foreach ($checkTables as $table) {
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
            echo "- {$table}: " . $count . " records\n";
        } catch (Exception $e) {
            echo "- {$table}: ERROR - " . $e->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "[FAIL] Connection Error: " . $e->getMessage() . "\n";
}