<?php

require_once __DIR__ . '/../db.php';

$index_file = __DIR__ . '/system_index_cache.json';

if (!file_exists($index_file)) {
    require_once __DIR__ . '/system_index.php';
}

$index = json_decode(file_get_contents($index_file), true);

function render_tree($items) {
    echo "<ul style='list-style:none;padding-left:16px;'>";

    foreach ($items as $item) {

        echo "<li style='margin:4px 0'>";

        if ($item['type'] === 'folder') {
            echo "📁 <strong>{$item['name']}</strong>";
            if (!empty($item['children'])) {
                render_tree($item['children']);
            }
        } else {
            echo "📄 <a href='/{$item['path']}' target='_blank'>{$item['name']}</a>";
        }

        echo "</li>";
    }

    echo "</ul>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>LEGAiSEE GOD MODE</title>
    <style>

        body {
            font-family: Arial;
            background: #0e0e10;
            color: #eaeaea;
            margin: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 280px 1fr 320px;
            height: 100vh;
        }

        .panel {
            padding: 16px;
            overflow: auto;
            border-right: 1px solid #222;
        }

        .center {
            padding: 16px;
            overflow: auto;
        }

        .right {
            padding: 16px;
            border-left: 1px solid #222;
        }

        .card {
            background: #1a1a1d;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            background: #111;
            color: #fff;
            border: 1px solid #333;
        }

        button {
            padding: 8px;
            width: 100%;
            margin-top: 6px;
        }

    </style>
</head>
<body>

<div class="grid">

    <!-- LEFT: SYSTEM TREE -->
    <div class="panel">
        <h3>System Tree</h3>
        <?php render_tree($index['modules']); ?>
        <?php render_tree($index['engine']); ?>
        <?php render_tree($index['kernel']); ?>
        <?php render_tree($index['api']); ?>
        <?php render_tree($index['pages']); ?>
    </div>

    <!-- CENTER -->
    <div class="center">

        <div class="card">
            <h3>System Overview</h3>
            <p>LEGAiSEE God Mode Navigation Layer v1</p>
        </div>

        <div class="card">
            <h3>Quick Search</h3>
            <input type="text" placeholder="Search system..." />
        </div>

        <div class="card">
            <h3>Execution Console</h3>
            <textarea rows="4" placeholder="run engine goal_engine"></textarea>
            <button>Execute</button>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <div class="card">
            <h3>Today</h3>
            <p>No tasks yet (next file adds this)</p>
        </div>

        <div class="card">
            <h3>Weekly Focus</h3>
            <p>Not set</p>
        </div>

        <div class="card">
            <h3>System Activity</h3>
            <p>Idle</p>
        </div>

    </div>

</div>

</body>
</html>