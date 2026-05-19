<?php

require_once __DIR__ . "/kernel.php";

/*
=====================================
 KERNEL GUARD (SYSTEM ENFORCER)
=====================================
This prevents:
- missing DB injection
- silent bootstrap failure
- inconsistent execution context
*/

function kernel_guard() {

    $pdo = kernel_db();

    if (!$pdo) {
        die("KERNEL GUARD FAILURE: DB not available");
    }

    return $pdo;
}