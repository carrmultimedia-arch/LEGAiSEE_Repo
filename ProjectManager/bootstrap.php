<?php

declare(strict_types=1);

define('BASE_PATH', __DIR__);

$config = require BASE_PATH . '/config.php';

spl_autoload_register(function (string $class): void {
    if ($class === 'App\\Database\\Connection') {

        $file = BASE_PATH . '/database/connection.php';

        if (file_exists($file)) {
            require_once $file;
        }

        return;
    }
    $prefix = 'App\\';

    $baseDirectory = BASE_PATH . '/app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));

    $parts = explode('\\', $relativeClass);

    $folder = $parts[0];

    unset($parts[0]);

    $file = $baseDirectory
        . $folder
        . '/'
        . implode('/', $parts)
        . '.php';

    if (file_exists($file)) {
        require_once $file;
    }

});


$GLOBALS['config'] = $config;


set_exception_handler(
    function (Throwable $exception): void {

        if (class_exists(\App\Core\ExceptionHandler::class)) {
            \App\Core\ExceptionHandler::handle($exception);
            return;
        }

        http_response_code(500);

        echo 'Application Error';

    }
);


return $config;