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
        WHERE case_id=$case_id AND task_type='recommendation'
        ORDER BY id DESC
        LIMIT 20
    ");

    $recs = [];

    while ($row = $result->fetch_assoc()) {
        $recs[] = $row;
    }

    json_response([
        "recommendation_count" => count($recs),
        "recommendations" => $recs
    ]);

} catch (Throwable $e) {
    json_error("recommendations failed", 500, [
        "exception" => $e->getMessage()
    ]);
}