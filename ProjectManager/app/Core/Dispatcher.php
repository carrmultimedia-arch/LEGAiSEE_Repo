<?php

declare(strict_types=1);

namespace App\Core;

use ReflectionMethod;

class Dispatcher
{
    public static function dispatch(
        mixed $handler,
        Request $request
    ): mixed {

        if (is_callable($handler)) {

            return $handler($request);

        }


        if (is_array($handler)) {

            return self::dispatchController(
                $handler,
                $request
            );

        }


        throw new \RuntimeException(
            'Invalid route handler'
        );
    }


    private static function dispatchController(
        array $handler,
        Request $request
    ): mixed {

        if (count($handler) !== 2) {

            throw new \RuntimeException(
                'Invalid controller definition'
            );

        }


        [$controller, $method] = $handler;


        if (is_string($controller)) {

            $controller = new $controller();

        }


        $reflection = new ReflectionMethod(
            $controller,
            $method
        );


        $parameters = $reflection->getParameters();


        if (count($parameters) === 0) {

            return $controller->$method();

        }


        return $controller->$method(
            $request
        );
    }
}