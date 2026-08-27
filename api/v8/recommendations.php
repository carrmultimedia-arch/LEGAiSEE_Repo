<?php

require_once __DIR__ . '/../../engine/recommendation_engine.php';
require_once __DIR__ . '/../../response.php';

try {
    $case_id = $_GET['case_id'] ?? null;

    if (!$case_id) {
        json_error("case_id is required.", 400);
    }

    $recommendations = generate_recommendations_for_case($case_id);
    json_response($recommendations);

} catch (Throwable $e) {
    json_error("recommendations failed: " . $e->getMessage(), 500);
}