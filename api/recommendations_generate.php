<?php

require_once __DIR__ . '/../../kernel/recommendation_engine.php';

$case_id = $_GET['case_id'] ?? 0;

$network_file = __DIR__ . "/../../data/network/net_case_" . $case_id . ".json";

$recommendations = generateRecommendations($network_file);

echo json_encode([
    "status" => "ok",
    "recommendation_count" => count($recommendations),
    "recommendations" => $recommendations
]);