<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

/* =====================================================
   DATABASE CONNECTION (LOCKED)
===================================================== */

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=carrmulti_legaiseearchive;charset=utf8mb4",
        "carrmulti",
        "Jmc6253277$",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Throwable $e) {
    die("DB CONNECTION FAILED: " . $e->getMessage());
}

/* =====================================================
   FETCH INGEST DATA
===================================================== */

try {

    $stmt = $db->query("
        SELECT
            id,
            domain_id,
            project_id,
            source_ai,
            session_title,
            LEFT(raw_transcript, 300) AS preview,
            created_at
        FROM memory_ingest
        ORDER BY id DESC
        LIMIT 100
    ");

    $rows = $stmt->fetchAll();

} catch (Throwable $e) {
    die("QUERY FAILED: " . $e->getMessage());
}
$single = null;

if (isset($_GET['id'])) {

    $stmt = $db->prepare("
        SELECT *
        FROM memory_ingest
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute([':id' => (int)$_GET['id']]);
    $single = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LEGAiSEE — Memory View</title>

<style>

body {
    margin: 0;
    padding: 40px;
    font-family: Arial, sans-serif;
    background: #0b0b0d;
    color: #d6b35a;
}

/* HEADER */

h1 {
    margin-bottom: 5px;
}

.sub {
    color: #8a6a2a;
    font-size: 12px;
    margin-bottom: 20px;
}

/* GRID */

.grid {
    display: grid;
    gap: 12px;
}

/* CARD */

.card {
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    padding: 14px;
    border-radius: 12px;
}

/* META */

.meta {
    font-size: 11px;
    color: #8a6a2a;
    margin-bottom: 8px;
}

/* TITLE */

.title {
    font-size: 14px;
    color: #f4e185;
    margin-bottom: 6px;
}

/* PREVIEW */

.preview {
    font-size: 12px;
    color: #cdb069;
    opacity: 0.9;
    line-height: 1.5;
    white-space: pre-wrap;
}

.badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 999px;
    background: #111;
    border: 1px solid #333;
    font-size: 10px;
    margin-right: 6px;
}

</style>
</head>
<a href="temp_dashboard.php"
   style="
        display:inline-block;
        margin-bottom:20px;
        padding:10px 14px;
        border-radius:999px;
        background:#111;
        border:1px solid #333;
        color:#f4e185;
        text-decoration:none;
   ">
   ← Back to Dashboard
</a>
<body>
<?php if ($single): ?>

<div class="card">

    <a href="view_ingest.php"
       style="display:inline-block;margin-bottom:10px;color:#f4e185;">
        ← Back to List
    </a>

    <div class="meta">
        ID: <?= htmlspecialchars((string)$single['id']) ?>
    </div>

    <div class="title">
        <?= htmlspecialchars($single['session_title']) ?>
    </div>

    <div class="preview">
        <?= nl2br(htmlspecialchars($single['raw_transcript'])) ?>
    </div>

</div>

<hr>

<?php endif; ?>
<h1>Memory Ingest View</h1>
<div class="sub">Live data from memory_ingest table</div>

<div class="grid">

<?php if (empty($rows)): ?>

    <div class="card">No ingest records found.</div>

<?php else: ?>

    <?php foreach ($rows as $r): ?>

<div class="card">

    <div class="meta">
        ID: <?= htmlspecialchars((string)$r['id']) ?> |
        <?= htmlspecialchars($r['source_ai'] ?? '') ?> |
        <?= htmlspecialchars($r['created_at'] ?? '') ?>
    </div>

    <div class="title">
        <?= htmlspecialchars($r['session_title'] ?: 'Untitled Session') ?>
    </div>

    <div class="preview">
        <?= htmlspecialchars($r['preview'] ?? '') ?>
    </div>

    <!-- NEW VIEW BUTTON -->
    <div style="margin-top:10px;">
        <a href="?id=<?= (int)$r['id'] ?>"
           style="
                display:inline-block;
                padding:6px 12px;
                border-radius:999px;
                background:#f4e185;
                color:#111;
                text-decoration:none;
                font-size:12px;
                font-weight:bold;
           ">
            Open Full Entry →
        </a>
    </div>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>