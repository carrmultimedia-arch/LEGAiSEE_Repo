<?php

function ui_tag($props = [])
{
    $label = '';

    if (isset($props['label'])) {
        $label = $props['label'];
    }

    return "<span class='ui-card-tag'>" . $label . "</span>";
}