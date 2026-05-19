<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/_response.php';

try {

    $case_id = intval($_GET['case_id'] ?? 0);

    if (!$case_id) {
        json_error("missing case_id", 400);
    }

    $result = $conn->query("
        SELECT * FROM processing_queue
        WHERE case_id=$case_id AND task_type='insight'
        ORDER BY id DESC
        LIMIT 20
    ");

    $insights = [];

    while ($row = $result->fetch_assoc()) {
        $insights[] = $row;
    }

    json_response([
        "insight_count" => count($insights),
        "insights" => $insights
    ]);

} catch (Throwable $e) {
    json_error("insights failed", 500, [
        "exception" => $e->getMessage()
    ]);
}