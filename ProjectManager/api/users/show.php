<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\UserController;
use App\Repositories\UserRepository;

header('Content-Type: application/json');

$controller = new UserController(
    new UserRepository()
);

try {

    if (!isset($_GET['id'])) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Missing user id.'
        ]);

        exit;
    }

    echo json_encode(
        $controller->show(
            (int) $_GET['id']
        )
    );

} catch (Throwable $exception) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $exception->getMessage()
    ]);
}