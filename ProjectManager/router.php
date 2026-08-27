<?php

declare(strict_types=1);

use App\Core\Application;

require_once __DIR__ . '/bootstrap.php';


$app = new Application();


$router = $app->getRouter();


// Application routes will be registered here
// by owned API/controller build chapters.


$app->run();