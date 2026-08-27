<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\AuthController;
use App\Repositories\UserRepository;
use App\Services\AuthorizationService;

header('Content-Type: application/json');

$controller = new AuthController(
    new UserRepository(),
    new AuthorizationService()
);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);

    exit;
}

try {

    echo json_encode(
        $controller->status()
    );

} catch (Throwable $exception) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $exception->getMessage()
    ]);
}