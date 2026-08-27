<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\ProjectMemberController;
use App\Repositories\ProjectMemberRepository;

header('Content-Type: application/json');

$controller = new ProjectMemberController(
    new ProjectMemberRepository()
);

$method = $_SERVER['REQUEST_METHOD'];

try {

    switch ($method) {

        case 'GET':

            if (isset($_GET['project_id'])) {

                echo json_encode(
                    $controller->projectMembers(
                        (int) $_GET['project_id']
                    )
                );

            } elseif (isset($_GET['user_id'])) {

                echo json_encode(
                    $controller->userProjects(
                        (int) $_GET['user_id']
                    )
                );

            } elseif (isset($_GET['id'])) {

                echo json_encode(
                    $controller->show(
                        (int) $_GET['id']
                    )
                );

            } else {

                echo json_encode(
                    $controller->index()
                );

            }

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
                    (int) $input['id'],
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
                    (int) $query['id']
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