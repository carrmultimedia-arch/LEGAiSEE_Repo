<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $connection = null;

    public static function get(): PDO
    {
        if (self::$connection === null) {

            $configFile = __DIR__ . '/../config.php';

            if (!file_exists($configFile)) {
                throw new PDOException(
                    'Missing config.php'
                );
            }

            $config = require $configFile;

            if (!isset($config['database'])) {
                throw new PDOException(
                    'Database configuration missing'
                );
            }

            self::$connection = new PDO(
                $config['database']['dsn'],
                $config['database']['username'],
                $config['database']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        return self::$connection;
    }
}