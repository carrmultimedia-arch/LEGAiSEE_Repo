<?php

require_once __DIR__ . '/../../engine/semantic_cluster_engine.php';
require_once __DIR__ . '/../../kernel/db.php';
require_once __DIR__ . '/../../response.php';

try {
    $case_id = $_GET['case_id'] ?? null;

    if (!$case_id) {
        json_error("case_id is required.", 400);
    }

    $pdo = kernel_db();
    $stmt = $pdo->prepare("
        SELECT content FROM entities WHERE context = ?
    ");
    $stmt->execute([$case_id]);
    $nodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $clusters = buildSemanticClusters($nodes);
    json_response(['cluster_count' => count($clusters), 'clusters' => $clusters]);

} catch (Throwable $e) {
    json_error("cluster insights failed: " . $e->getMessage(), 500);
}