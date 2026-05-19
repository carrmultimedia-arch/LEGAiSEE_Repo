<?php

if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}

if (!function_exists('log_msg')) {
    function log_msg($msg) {
        error_log('[LEGAiSEE] ' . print_r($msg, true));
    }
}