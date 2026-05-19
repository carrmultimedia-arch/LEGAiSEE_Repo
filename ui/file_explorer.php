<?php

require_once __DIR__ . '/../kernel/folder_engine.php';

$tree = folder_get_tree($pdo);

function render_tree($tree) {
    foreach ($tree as $node) {
        echo "<div style='margin-left:10px'>";
        echo "<a href='?module=files&folder=" . $node['id'] . "'>📁 " . htmlspecialchars($node['name']) . "</a>";
        
        if (!empty($node['children'])) {
            render_tree($node['children']);
        }

        echo "</div>";
    }
}
?>

<div style="width:250px; background:#111; color:#fff; padding:10px;">
    <h3>Files</h3>

    <form method="post" action="?module=files&action=create_folder">
        <input type="text" name="folder_name" placeholder="New Folder" required>
        <button type="submit">+</button>
    </form>

    <hr>

    <?php render_tree($tree); ?>
</div>