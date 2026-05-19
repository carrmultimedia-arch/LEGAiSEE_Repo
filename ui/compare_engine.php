<?php

class UICompareEngine {

    public static function render(array $left, array $right, bool $sideBySide = true): string {

        if (!$sideBySide) {
            return self::renderSingle($left, $right);
        }

        return "
        <div class='compare-toolbar'>
            <button onclick='toggleCompare()'>Toggle View</button>
        </div>

        <div id='compare-container' class='compare-grid'>
            <div class='compare-col'>
                " . self::renderPane("A", $left) . "
            </div>

            <div class='compare-col'>
                " . self::renderPane("B", $right) . "
            </div>
        </div>

        <script>
            function toggleCompare() {
                document.getElementById('compare-container').classList.toggle('single');
            }
        </script>
        ";
    }

    private static function renderPane(string $label, array $data): string {

        $out = "<div class='compare-label'>SET {$label}</div>";

        foreach ($data as $row) {
            $out .= "
            <div class='compare-item'>
                <strong>{$row['title']}</strong>
                <div>{$row['content']}</div>
            </div>";
        }

        return $out;
    }

    private static function renderSingle(array $left, array $right): string {

        return "<pre>" .
            json_encode(['A'=>$left,'B'=>$right], JSON_PRETTY_PRINT)
        . "</pre>";
    }
}