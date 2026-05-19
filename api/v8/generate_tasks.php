<?php

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/../db.php';

try {

    $case_id = isset($_GET['case_id']) ? intval($_GET['case_id']) : 0;

    // TEMP SAFE OUTPUT (NO LOGIC YET)
    echo json_encode([
        "status" => "ok",
        "insight_count" => 1,
        "insights" => [
            [
                "cluster" => "media",
                "size" => 3,
                "strength" => 24.3,
                "insights" => [
                    "Cluster loaded successfully (stub)."
                ]
            ]
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

exit;