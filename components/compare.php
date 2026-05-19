<?php

function ui_compare(array $props, $content = null): string
{
    $a = $props['a'] ?? '';
    $b = $props['b'] ?? '';
    $mode = $props['mode'] ?? 'side_by_side';

    if ($mode === 'single') {
        return "<div class='ui-card'>{$a}</div>";
    }

    return "
    <div style='display:grid;grid-template-columns:1fr 1fr;gap:12px;'>
        <div class='ui-card'>
            <div class='ui-card-tag'>A</div>
            {$a}
        </div>
        <div class='ui-card'>
            <div class='ui-card-tag'>B</div>
            {$b}
        </div>
    </div>";
}