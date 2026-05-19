<?php    

function ui_folder_tree(array $tree): string
{
    $html = "<ul style='list-style:none; padding-left:10px;'>";

    foreach ($tree as $node) {

        $html .= "<li>";
        $html .= "📁" . htmlspecialchars($node['name']);

        if (!empty($node['children'])) {
            $html .= ui_folder_tree($node['children']);
        }

        $html .= "</li>";
    }

    $html .= "</ul>";

    return $html;
}