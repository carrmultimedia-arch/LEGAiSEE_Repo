<?php

if (!function_exists('safe_file_get')) {
    function safe_file_get($path) {
        return file_exists($path) ? file_get_contents($path) : null;
    }
}

if (!function_exists('safe_json_get')) {
    function safe_json_get($path) {
        if (!file_exists($path)) return null;

        $data = json_decode(file_get_contents($path), true);
        return json_last_error() === JSON_ERROR_NONE ? $data : null;
    }
}