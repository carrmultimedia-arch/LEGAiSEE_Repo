<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

class ExceptionHandler
{
    public static function handle(
        Throwable $exception
    ): void {

        http_response_code(500);


        if (
            isset($GLOBALS['config']['app']['debug'])
            &&
            $GLOBALS['config']['app']['debug'] === true
        ) {

            header(
                'Content-Type: application/json'
            );


            echo json_encode(
                [
                    'error' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ],
                JSON_PRETTY_PRINT
            );


            return;

        }


        header(
            'Content-Type: application/json'
        );


        echo json_encode(
            [
                'error' => 'Application Error',
            ]
        );
    }
}