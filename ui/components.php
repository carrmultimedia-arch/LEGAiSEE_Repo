<?php

function ui_folder_tree(array $tree): string {

    $html = "<ul class='folder-tree'>";

    foreach ($tree as $node) {

        $html .= "<li class='folder-node'>";

        $html .= "
            <a class='folder-link' href='?module=files&folder={$node['id']}'>
                📁 {$node['name']}
            </a>
        ";

        if (!empty($node['children'])) {
            $html .= ui_folder_tree($node['children']);
        }

        $html .= "</li>";
    }

    $html .= "</ul>";

    return $html;
}