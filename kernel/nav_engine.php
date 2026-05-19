<?php

function kernel_nav_push() {

    $current = $_SERVER['REQUEST_URI'];

    if (!isset($_SESSION['nav_history'])) {
        $_SESSION['nav_history'] = [];
    }

    $history = &$_SESSION['nav_history'];

    // prevent duplicate consecutive entries
    if (empty($history) || end($history) !== $current) {
        $history[] = $current;
    }

    // limit stack size
    if (count($history) > 50) {
        array_shift($history);
    }
}

function kernel_nav_back() {

    if (empty($_SESSION['nav_history'])) {
        return null;
    }

    $history = &$_SESSION['nav_history'];

    array_pop($history); // remove current

    return end($history) ?: null;
}