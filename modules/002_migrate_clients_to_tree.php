<?php

require_once __DIR__ . '/../kernel/db.php';

echo "Running Migration: Migrate clients to tree_nodes...\n";

try {
    $pdo = kernel_db();
    $pdo->beginTransaction();

    // Fetch all clients
    $clients = $pdo->query("SELECT id, name FROM clients")->fetchAll(PDO::FETCH_ASSOC);

    $insertStmt = $pdo->prepare(
        "INSERT INTO tree_nodes (parent_id, name, type, metadata) VALUES (NULL, ?, 'client', ?)"
    );

    $migratedCount = 0;
    foreach ($clients as $client) {
        $metadata = json_encode(['client_db_id' => $client['id']]);
        $insertStmt->execute([$client['name'], $metadata]);
        $migratedCount++;
    }

    $pdo->commit();
    echo "[OK] Migrated {$migratedCount} clients to tree_nodes.\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "[FAIL] Error migrating clients: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Migration complete.\n";