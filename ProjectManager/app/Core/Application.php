<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    private Container $container;

    private Router $router;


    public function __construct()
    {
        $this->container = new Container();

        $this->router = new Router();

        $this->registerCoreServices();
    }


    private function registerCoreServices(): void
    {
        $this->container->singleton(
            Router::class,
            fn () => $this->router
        );

        $this->container->singleton(
            Request::class,
            fn () => Request::capture()
        );

        $this->container->singleton(
            Response::class,
            fn () => new Response()
        );
    }


    public function getContainer(): Container
    {
        return $this->container;
    }


    public function getRouter(): Router
    {
        return $this->router;
    }


    public function run(): void
    {
        try {

            $request = $this->container->make(Request::class);

            $response = $this->router->dispatch($request);

            if ($response instanceof Response) {
                $response->send();
                return;
            }

            echo $response;

        } catch (\Throwable $exception) {

            ExceptionHandler::handle($exception);

        }
    }
}