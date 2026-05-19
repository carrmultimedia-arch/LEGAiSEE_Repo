<?php

declare(strict_types=1);

/*
|------------------------------------------------------------
| UI CORE (SINGLE SOURCE OF TRUTH)
|------------------------------------------------------------
| - NO DUPLICATES ALLOWED
| - NO MODULE LOGIC
| - ONLY SAFE RENDER HELPERS
|------------------------------------------------------------
*/

if (!function_exists('ui_shell')) {

    function ui_shell(string $content): string
    {
        return '
        <div style="background:#0a0a0a;color:#fff;font-family:Inter;padding:24px;">
            <div style="max-width:1200px;margin:0 auto;">
                ' . $content . '
            </div>
        </div>';
    }
}

if (!function_exists('ui_card')) {

    function ui_card(string $title, string $content): string
    {
        return '
        <div style="background:#111;border:1px solid rgba(212,175,55,0.15);padding:20px;margin-bottom:16px;">
            <div style="color:#D4AF37;font-weight:600;margin-bottom:10px;">' . htmlspecialchars($title) . '</div>
            <div style="color:#ccc;">' . $content . '</div>
        </div>';
    }
}