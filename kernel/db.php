<?php

require_once __DIR__ . '/../config.php';

function kernel_db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Use json_error if available, otherwise die.
            function_exists('json_error') ? json_error("Database connection failed: " . $e->getMessage(), 500) : die("DB ERROR: " . $e->getMessage());
        }
    }
    return $pdo;
}