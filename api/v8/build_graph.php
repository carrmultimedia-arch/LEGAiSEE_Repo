<?php

require_once __DIR__ . '/../../engine/graph_engine.php';
require_once __DIR__ . '/../../response.php';

try {
    $case_id = $_POST['case_id'] ?? null;

    if (!$case_id) {
        json_error("missing case_id", 400);
    }

    $result = queue_graph_build_for_case($case_id);
    json_response($result);

} catch (Throwable $e) {
    json_error("build_graph failed: " . $e->getMessage(), 500);
}