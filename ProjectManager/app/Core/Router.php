<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];


    public function get(
        string $path,
        mixed $handler
    ): void {
        $this->addRoute(
            'GET',
            $path,
            $handler
        );
    }


    public function post(
        string $path,
        mixed $handler
    ): void {
        $this->addRoute(
            'POST',
            $path,
            $handler
        );
    }


    public function put(
        string $path,
        mixed $handler
    ): void {
        $this->addRoute(
            'PUT',
            $path,
            $handler
        );
    }


    public function delete(
        string $path,
        mixed $handler
    ): void {
        $this->addRoute(
            'DELETE',
            $path,
            $handler
        );
    }


    private function addRoute(
        string $method,
        string $path,
        mixed $handler
    ): void {
        $this->routes[$method][$path] = $handler;
    }


    public function dispatch(Request $request): mixed
    {
        $method = $request->method();

        $uri = $request->uri();


        if (!isset($this->routes[$method][$uri])) {

            return new Response(
                'Not Found',
                404
            );

        }


        return Dispatcher::dispatch(
            $this->routes[$method][$uri],
            $request
        );
    }


    public function routes(): array
    {
        return $this->routes;
    }
}