<?php

function ui_component(string $name, array $props = []): string {

    $registry = require __DIR__ . '/component_registry.php';

    if (!isset($registry[$name])) {
        return "<!-- UI COMPONENT MISSING: {$name} -->";
    }

    $file = __DIR__ . '/' . $registry[$name];

    if (!file_exists($file)) {
        return "<!-- UI FILE MISSING: {$file} -->";
    }

    return (function () use ($file, $props) {
        extract($props);
        ob_start();
        include $file;
        return ob_get_clean();
    })();
}