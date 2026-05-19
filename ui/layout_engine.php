<?php
declare(strict_types=1);

function ui_render_layout(array $layout): string
{
    $html = "<div class='layout-grid'>";

    foreach ($layout as $node) {

        if (!is_array($node)) {
            continue;
        }

        $type  = $node['type']  ?? null;
        $props = $node['props'] ?? [];

        if (!$type) {
            continue;
        }

        $html .= ui($type, $props);
    }

    $html .= "</div>";

    return $html;
}