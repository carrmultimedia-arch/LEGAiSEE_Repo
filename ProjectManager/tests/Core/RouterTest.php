<?php

class RouterTest
{
    public function testRouteRegistration(): bool
    {
        $router = new Router();

        $router->get('/test', function () {
            return new Response('ok');
        });

        $request = new Request();

        return true;
    }
}