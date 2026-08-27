<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\UserController;
use App\Repositories\UserRepository;

header('Content-Type: application/json');

$controller = new UserController(
    new UserRepository()
);

$method = $_SERVER['REQUEST_METHOD'];

try {

    switch ($method) {

        case 'GET':

            echo json_encode(
                $controller->index()
            );

            break;

        case 'POST':

            $input = json_decode(
                file_get_contents('php://input'),
                true
            ) ?? [];

            echo json_encode(
                $controller->store($input)
            );

            break;

        case 'PUT':

            $input = json_decode(
                file_get_contents('php://input'),
                true
            ) ?? [];

            echo json_encode(
                $controller->update(
                    (int)$input['id'],
                    $input
                )
            );

            break;

        case 'DELETE':

            parse_str(
                $_SERVER['QUERY_STRING'],
                $query
            );

            echo json_encode(
                $controller->destroy(
                    (int)$query['id']
                )
            );

            break;

        default:

            http_response_code(405);

            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
    }

} catch (Throwable $exception) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $exception->getMessage()
    ]);
}