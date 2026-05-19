<?php

function ui_card(array $props): string
{
    $title   = $props['title'] ?? '';
    $content = $props['content'] ?? '';
    $footer  = $props['footer'] ?? '';
    $tag     = $props['tag'] ?? null;

    $tagHtml = $tag ? "<span class='card-tag'>{$tag}</span>" : "";

    return "
    <div class='ui-card'>

        <div class='card-header'>
            <h3 class='card-title'>{$title}</h3>
            {$tagHtml}
        </div>

        <div class='card-body'>
            {$content}
        </div>

        " . ($footer ? "<div class='card-footer'>{$footer}</div>" : "") . "

    </div>
    ";
}