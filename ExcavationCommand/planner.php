<?php

require_once __DIR__ . '/../db.php';

// Temporary stub until integrated with LEGAiSEE kernel.
// Planner currently uses JSON storage instead of the database.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $task = trim($_POST['task'] ?? '');
    $type = $_POST['type'] ?? 'today';

    
}



?>

<h2>Planner</h2>

<form method="POST">
    <input name="task" placeholder="Add task..." />
    <select name="type">
        <option value="today">Today</option>
        <option value="week">Weekly</option>
        <option value="backlog">Backlog</option>
    </select>
    <button>Add</button>
</form>

<hr>

<?php foreach ($tasks as $t): ?>
    <div style="padding:6px;border-bottom:1px solid #333">
        <strong>[<?= $t['type'] ?>]</strong>
        <?= htmlspecialchars($t['task']) ?>
    </div>
<?php endforeach; ?>