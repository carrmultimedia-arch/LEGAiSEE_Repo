<?php

require_once __DIR__ . '/component_registry.php';

/* CORE COMPONENTS */
require_once __DIR__ . '/../components/ui_folder_tree.php';
require_once __DIR__ . '/../components/ui_card.php';
require_once __DIR__ . '/../components/ui_tag.php';

/* REGISTER COMPONENTS */

ui_register('folder_tree', function($props) {
    return ui_folder_tree($props['tree'] ?? []);
});

ui_register('card', function($props) {
    return ui_card($props);
});

ui_register('button', function($props) {
    return ui_button($props);
});

ui_register('tag', function($props) {
    return ui_tag($props['text'] ?? '');
});