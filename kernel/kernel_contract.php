<?php

if (!function_exists('kernel_validate_runtime')) {

    function kernel_validate_runtime() {

        if (!function_exists('kernel_db')) {
            die("KERNEL VIOLATION: DB NOT AVAILABLE");
        }

        try {
            $pdo = kernel_db();

            if (!$pdo instanceof PDO) {
                die("KERNEL VIOLATION: INVALID DB INSTANCE");
            }

        } catch (Throwable $e) {
            die("KERNEL VIOLATION: DB FAILURE");
        }

        return true;
    }

}