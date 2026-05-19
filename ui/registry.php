<?php

return [

    'card' => function(array $props = [], $content = '') {

        $title = $props['title'] ?? '';
        $tag   = $props['tag'] ?? '';
        $class = $props['class'] ?? '';

        return "
        <div class='ui-card {$class}'>
            " . ($tag ? "<div class='ui-card-tag'>{$tag}</div>" : "") . "
            " . ($title ? "<h3 class='ui-card-title'>{$title}</h3>" : "") . "
            <div class='ui-card-body'>{$content}</div>
        </div>";
    },

    'button' => function(array $props = []) {

        $label = $props['label'] ?? 'Button';
        $type  = $props['type'] ?? 'ghost';
        $onClick = $props['onClick'] ?? '';

        return "<button class='btn-{$type}' onclick=\"{$onClick}\">{$label}</button>";
    },

    'panel' => function(array $props = [], $content = '') {

        $title = $props['title'] ?? '';

        return "
        <section class='ui-panel'>
            " . ($title ? "<div class='ui-panel-title'>{$title}</div>" : "") . "
            <div class='ui-panel-body'>{$content}</div>
        </section>";
    }
    
'compare' => fn($p,$c) => ui_compare($p,$c),

];