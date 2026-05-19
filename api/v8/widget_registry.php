<?php

header('Content-Type: application/json');

/*
================================================
WIDGET REGISTRY (BACKEND AUTHORITATIVE UI SYSTEM)
================================================
*/

echo json_encode([

    "insight_card" => [
        "description" => "Basic insight display card",
        "schema" => [
            "title" => "string",
            "body" => "string",
            "confidence" => "number",
            "action" => "string",
            "color" => "string"
        ]
    ],

    "risk_meter" => [
        "description" => "Visual risk indicator",
        "schema" => [
            "label" => "string",
            "value" => "number",
            "max" => "number"
        ]
    ],

    "cluster_summary" => [
        "description" => "Cluster aggregation view",
        "schema" => [
            "name" => "string",
            "size" => "number",
            "strength" => "number",
            "type" => "string"
        ]
    ],

    "opportunity_banner" => [
        "description" => "High visibility opportunity alert",
        "schema" => [
            "headline" => "string",
            "detail" => "string",
            "impact" => "string"
        ]
    ]

], JSON_PRETTY_PRINT);