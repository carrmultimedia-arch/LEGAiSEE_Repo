<?php

require_once __DIR__ . '/../kernel/db.php';

function queue_graph_build_for_case(string $case_id): array
{
    if (empty($case_id)) {
        throw new InvalidArgumentException("Case ID cannot be empty.");
    }

    $pdo = kernel_db();
    $stmt = $pdo->prepare("
        INSERT INTO processing_queue (case_id, task_type, status)
        VALUES (?, 'build_graph', 'pending')
    ");
    $stmt->execute([$case_id]);

    return [
        "message" => "graph build queued",
        "case_id" => $case_id
    ];
}