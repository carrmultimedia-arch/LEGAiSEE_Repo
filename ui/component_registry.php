<?php
return [
    'card' => 'ui/components/card.php',
    'button' => 'ui/components/button.php',
    'heading' => 'ui/components/heading.php',
    'input' => 'ui/components/input.php',
    'folder_tree' => 'ui/components/folder_tree.php',
];
/**
 * LEGAiSEE UI COMPONENT REGISTRY
 * Central dispatcher for all UI components
 */

$UI_COMPONENTS = [];

/**
 * Register a component
 */
function ui_register(string $name, callable $handler): void {
    global $UI_COMPONENTS;
    $UI_COMPONENTS[$name] = $handler;
}

/**
 * Render a component
 */
function ui(string $name, array $props = []): string {
    global $UI_COMPONENTS;

    if (!isset($UI_COMPONENTS[$name])) {
        return "<!-- UI component not found: {$name} -->";
    }

    return call_user_func($UI_COMPONENTS[$name], $props);
}