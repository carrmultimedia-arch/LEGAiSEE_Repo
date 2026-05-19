<?php

require_once __DIR__ . '/kernel/kernel_boot.php';
require_once __DIR__ . '/kernel/kernel_contract.php';
require_once __DIR__ . '/kernel/module_contract.php';

define('KERNEL_BOOTED', true);

$pdo = kernel_db();

$GLOBALS['pdo'] = $pdo;

$registry = require __DIR__ . '/kernel/module_registry.php';

echo "<h2>MODULE LOAD TEST</h2>";

foreach ($registry as $key => $file) {

    $path = __DIR__ . '/modules/' . $file;

    try {

        if (!file_exists($path)) {
            throw new Exception("FILE MISSING");
        }

        $GLOBALS['KERNEL_MODULE'] = $key;

        ob_start();
        require $path;
        ob_end_clean();

        echo "✔ OK: {$file}<br>";

    } catch (Throwable $e) {

        echo "❌ FAIL: {$file} → " . $e->getMessage() . "<br>";
    }
}