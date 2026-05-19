<?php
require_once "db.php";

// -----------------------------
// SAVE NEW VIEW
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO saved_views (name, project, platform, type, keyword)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['name'] ?? '',
        $_POST['project'] ?? null,
        $_POST['platform'] ?? null,
        $_POST['type'] ?? null,
        $_POST['keyword'] ?? null
    ]);

    header("Location: saved_views.php");
    exit;
}

// -----------------------------
// LOAD SAVED VIEWS
// -----------------------------
$views = $pdo->query("SELECT * FROM saved_views ORDER BY created DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saved Intelligence Views</title>

    <style>
        body {
            background:#0e0e0e;
            color:#f5f5f5;
            font-family: Arial;
        }

        .container {
            padding:20px;
        }

        .card {
            background:#1a1a1a;
            border:1px solid rgba(245,199,106,0.2);
            padding:15px;
            margin-bottom:10px;
            border-radius:10px;
        }

        .btn {
            background: linear-gradient(135deg, #f5c76a, #c89b3c);
            border:none;
            padding:8px 12px;
            cursor:pointer;
            display:inline-block;
            margin-top:5px;
            color:#000;
            text-decoration:none;
        }

        input {
            padding:8px;
            margin:5px;
            background:#111;
            border:1px solid #333;
            color:#fff;
        }

        .form-box {
            background:#151515;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        }
    </style>
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

<h2 style="color:#f5c76a;">Saved Intelligence Views</h2>

<!-- =========================
     SAVE NEW VIEW FORM
========================= -->
<div class="form-box">

<form method="POST">

    <input type="text" name="name" placeholder="View Name" required>

    <input type="text" name="project" placeholder="Project (optional)">
    <input type="text" name="platform" placeholder="Platform (optional)">
    <input type="text" name="type" placeholder="Type (optional)">
    <input type="text" name="keyword" placeholder="Keyword (optional)">

    <button class="btn" type="submit">Save View</button>

</form>

</div>

<!-- =========================
     SAVED VIEWS LIST
========================= -->

<?php foreach ($views as $v): ?>

    <div class="card">
        <strong><?= htmlspecialchars($v['name']) ?></strong><br>

        <small>
            Project: <?= $v['project'] ?? 'ANY' ?> |
            Platform: <?= $v['platform'] ?? 'ANY' ?> |
            Type: <?= $v['type'] ?? 'ANY' ?> |
            Keyword: <?= $v['keyword'] ?? 'ANY' ?>
        </small>

        <br>

        <a class="btn"
           href="search.php?project=<?= urlencode($v['project']) ?>
           &platform=<?= urlencode($v['platform']) ?>
           &type=<?= urlencode($v['type']) ?>
           &q=<?= urlencode($v['keyword']) ?>">
           Run View
        </a>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>