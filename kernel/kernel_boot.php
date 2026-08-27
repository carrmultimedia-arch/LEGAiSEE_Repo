<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

require_once __DIR__ . '/kernel_paths.php';

if (file_exists(__DIR__ . '/../ui/ui_bootstrap.php')) {
    require_once __DIR__ . '/../ui/ui_bootstrap.php';
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* -----------------------------------------------
   GLOBAL $db FALLBACK
   Modules built before kernel_db() existed use $db
   directly. This makes both approaches work.
----------------------------------------------- */

global $db;
try {
    $db = kernel_db();
} catch (Throwable $e) {
    $db = null;
}

/* -----------------------------------------------
   KERNEL VALIDATE RUNTIME
   Called by cluster, compare, report, view modules
----------------------------------------------- */

function kernel_validate_runtime(): bool
{
    global $db;
    return $db instanceof PDO;
}

/* -----------------------------------------------
   KERNEL ASSETS
----------------------------------------------- */

function kernel_assets(): string
{
    if (function_exists('legaisee_ui_bootstrap')) {
        return legaisee_ui_bootstrap();
    }
    return '';
}