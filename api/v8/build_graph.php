<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/_response.php';

try {

    $case_id = intval($_POST['case_id'] ?? 0);

    if (!$case_id) {
        json_error("missing case_id", 400);
    }

    // mark graph build task (simple placeholder)
    $conn->query("
        INSERT INTO processing_queue (case_id, task_type, status)
        VALUES ($case_id, 'build_graph', 'pending')
    ");

    json_response([
        "message" => "graph build queued",
        "case_id" => $case_id
    ]);

} catch (Throwable $e) {
    json_error("build_graph failed", 500, [
        "exception" => $e->getMessage()
    ]);
}