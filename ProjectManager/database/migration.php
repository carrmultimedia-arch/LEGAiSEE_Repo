<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap.php';

use App\Database\Connection;

echo "Starting migration process...\n";

try {

    $pdo = Connection::get();

    $migrationPath = __DIR__ . '/migrations';

    if (!is_dir($migrationPath)) {
        throw new RuntimeException(
            "Migration directory not found: {$migrationPath}"
        );
    }

    $files = glob($migrationPath . '/*.php');

    if ($files === false) {
        throw new RuntimeException(
            "Unable to read migration directory."
        );
    }


    /*
     * Sort migrations numerically by filename prefix.
     *
     * Example:
     * 001_create_users_table.php
     * 010_create_tasks_table.php
     */
    usort($files, function ($a, $b) {

        preg_match('/^(\d+)/', basename($a), $matchA);
        preg_match('/^(\d+)/', basename($b), $matchB);

        $numberA = isset($matchA[1])
            ? (int)$matchA[1]
            : PHP_INT_MAX;

        $numberB = isset($matchB[1])
            ? (int)$matchB[1]
            : PHP_INT_MAX;

        return $numberA <=> $numberB;
    });


    foreach ($files as $file) {

        $filename = basename($file);

        echo "Running migration: {$filename}\n";

        require $file;
    }


    echo "\nMigration process complete.\n";


} catch (Throwable $e) {

    echo "\nMigration failed:\n";
    echo $e->getMessage() . "\n";

    exit(1);
}