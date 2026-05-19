<?php

/*
|------------------------------------------------------------
| UI ENGINE — SINGLE RENDER PIPELINE
|------------------------------------------------------------
| This is the ONLY place that loads layout.php
|------------------------------------------------------------
*/

function ui_page(string $title, string $body): string {

    // Wrap content BEFORE layout
    $content = "
        <div class='ui-page'>
            <h1>{$title}</h1>
            {$body}
        </div>
    ";

    // Start buffer
    ob_start();

    // Make $content available to layout.php
    require __DIR__ . '/layout.php';

    // Return full rendered page
    return ob_get_clean();
}

/*
|------------------------------------------------------------
| PANEL (optional structured blocks)
|------------------------------------------------------------
*/
function ui_panel(string $title, string $body): string {
    return "
        <div class='card'>
            <div class='card-title'>{$title}</div>
            <div>{$body}</div>
        </div>
    ";
}