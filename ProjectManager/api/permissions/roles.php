<?php

require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\AuthController;

$controller = new AuthController();

$response = $controller->roles();

http_response_code($response['status']);

header('Content-Type: application/json');

echo json_encode($response);