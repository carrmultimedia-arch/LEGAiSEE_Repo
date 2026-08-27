<?php
declare(strict_types=1);

$dbCredentials = require '/home/carrmulti/private/pm_db_credentials.php';

return [
    'app' => [
        'name' => 'LEGAiSEE Project Manager',
        'version' => '1.0',
        'environment' => 'production',
        'debug' => true,
    ],
    'database' => [
        'driver' => 'mysql',
        'host' => $dbCredentials['host'],
        'port' => $dbCredentials['port'],
        'database' => $dbCredentials['database'],
        'username' => $dbCredentials['username'],
        'password' => $dbCredentials['password'],
        'charset' => $dbCredentials['charset'],
        'dsn' => "mysql:host={$dbCredentials['host']};port={$dbCredentials['port']};dbname={$dbCredentials['database']};charset={$dbCredentials['charset']}",
    ],
    'paths' => [
        'base' => __DIR__,
        'storage' => __DIR__ . '/storage',
        'database' => __DIR__ . '/database',
    ],
];