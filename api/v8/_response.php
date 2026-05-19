<?php

/*
================================================
LEGAISEE API RESPONSE CONTRACT GUARD
================================================
ALL API endpoints MUST use this wrapper
to prevent UI crashes from invalid JSON.
================================================
*/

function json_response($data = [], $status = "ok", $httpCode = 200)
{
    // CRITICAL: stop PHP warnings from corrupting JSON
    if (ob_get_length()) {
        ob_clean();
    }

    header("Content-Type: application/json; charset=utf-8");
    http_response_code($httpCode);

    echo json_encode([
        "status" => $status,
        "timestamp" => date("c"),
        "data" => $data
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    exit;
}

function json_error($message = "unknown error", $code = 500, $extra = [])
{
    if (ob_get_length()) {
        ob_clean();
    }

    header("Content-Type: application/json; charset=utf-8");
    http_response_code($code);

    echo json_encode([
        "status" => "error",
        "message" => $message,
        "timestamp" => date("c"),
        "debug" => $extra
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    exit;
}