<?php
declare(strict_types=1);

/*
=====================================================
LEGAiSEE UIC v2 — UI COMPONENT LAYER
=====================================================
Deterministic UI system for all modules
Replaces inconsistent native form rendering
*/

if (!function_exists('uic_select')) {

    function uic_select(
        string $name,
        array $options,
        $selected = null,
        string $label = ''
    ): string {

        $html = "<div class='uic-field'>";

        if ($label !== '') {
            $html .= "<label class='uic-label'>{$label}</label>";
        }

        $html .= "<div class='uic-select-wrap'>";

        $html .= "<select name='{$name}' class='uic-select'>";

        foreach ($options as $value => $text) {

            $isSelected = ((string)$selected === (string)$value) ? 'selected' : '';

            $valueEsc = htmlspecialchars((string)$value);
            $textEsc  = htmlspecialchars((string)$text);

            $html .= "<option value='{$valueEsc}' {$isSelected}>{$textEsc}</option>";
        }

        $html .= "</select>";
        $html .= "</div></div>";

        return $html;
    }
}

if (!function_exists('uic_input')) {

    function uic_input(
        string $name,
        string $value = '',
        string $label = '',
        string $placeholder = ''
    ): string {

        $html = "<div class='uic-field'>";

        if ($label !== '') {
            $html .= "<label class='uic-label'>{$label}</label>";
        }

        $html .= "<input
            type='text'
            name='" . htmlspecialchars($name) . "'
            value='" . htmlspecialchars($value) . "'
            placeholder='" . htmlspecialchars($placeholder) . "'
            class='uic-input'
        />";

        $html .= "</div>";

        return $html;
    }
}

if (!function_exists('uic_textarea')) {

    function uic_textarea(
        string $name,
        string $value = '',
        string $label = '',
        int $rows = 10
    ): string {

        $html = "<div class='uic-field'>";

        if ($label !== '') {
            $html .= "<label class='uic-label'>{$label}</label>";
        }

        $html .= "<textarea
            name='" . htmlspecialchars($name) . "'
            rows='{$rows}'
            class='uic-textarea'
        >" . htmlspecialchars($value) . "</textarea>";

        $html .= "</div>";

        return $html;
    }
}