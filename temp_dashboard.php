<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

/* =====================================================
   DB CONNECTION (SINGLE SOURCE)
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
   INGEST HANDLER (INLINE)
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['raw_transcript'])) {

    $stmt = $db->prepare("
        INSERT INTO memory_ingest
        (domain_id, project_id, source_ai, session_title, raw_transcript)
        VALUES
        (:domain_id, :project_id, :source_ai, :session_title, :raw_transcript)
    ");

    $stmt->execute([
        ':domain_id'      => $_POST['domain_id'] ?? null,
        ':project_id'     => $_POST['project_id'] ?? null,
        ':source_ai'      => $_POST['source_ai'] ?? 'ChatGPT',
        ':session_title'  => $_POST['session_title'] ?? '',
        ':raw_transcript' => $_POST['raw_transcript'] ?? ''
    ]);

    echo "<div style='padding:10px;color:lime;'>INGEST SUCCESS</div>";
}

/* =====================================================
   LOAD DROPDOWNS
===================================================== */

$domains = $db->query("SELECT id, name FROM memory_domains ORDER BY name ASC")->fetchAll();
$projects = $db->query("SELECT id, name FROM projects ORDER BY name ASC")->fetchAll();

function opts(array $rows): string {
    $html = "<option value=''>Select</option>";
    foreach ($rows as $r) {
        $id = htmlspecialchars((string)$r['id']);
        $name = htmlspecialchars($r['name']);
        $html .= "<option value='{$id}'>{$name}</option>";
    }
    return $html;
}

$domainOptions  = opts($domains);
$projectOptions = opts($projects);

/* =====================================================
   VIEW DATA (LIVE)
===================================================== */

$rows = $db->query("
    SELECT id, source_ai, session_title, created_at
    FROM memory_ingest
    ORDER BY id DESC
    LIMIT 20
")->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LEGAiSEE — TEMP DASHBOARD</title>

<style>

/* =====================================================
   BASE
===================================================== */

body {
    margin: 0;
    padding: 30px;
    font-family: Arial, sans-serif;
    background: #0b0b0d;
    color: #d6b35a;
}

/* LAYOUT */

.wrap {
    max-width: 1200px;
    margin: auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

/* PANELS */

.panel {
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    padding: 20px;
    border-radius: 12px;
}

/* GRID */

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

label {
    font-size: 11px;
    color: #8a6a2a;
    text-transform: uppercase;
}

input, select, textarea {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #333;
    background: #111;
    color: #f4e185;
}

textarea {
    min-height: 160px;
}

.full {
    grid-column: 1 / -1;
}

/* BUTTON */

button {
    margin-top: 12px;
    width: 100%;
    padding: 12px;
    border-radius: 999px;
    border: none;
    background: #f4e185;
    color: #111;
    font-weight: bold;
    cursor: pointer;
}

/* LIST */

.item {
    padding: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.small {
    font-size: 11px;
    color: #8a6a2a;
}

</style>
</head>

<body>

<div class="wrap">

<!-- =====================================================
     EXEC SNAPSHOT
===================================================== -->

<div class="panel">
    <h2>Executive Snapshot</h2>
    <div class="small">
        Live ingestion + view pipeline active
    </div>

    <div>Total Records: <?= count($rows) ?></div>
</div>
    <!-- NEW BUTTON -->
    <div style="margin-top:15px;">
        <a href="view_ingest.php"
           style="
                display:inline-block;
                padding:10px 16px;
                border-radius:999px;
                background:#f4e185;
                color:#111;
                text-decoration:none;
                font-weight:bold;
           ">
            Open Full Ingest View →
        </a>
    </div>
<!-- =====================================================
     INGEST
===================================================== -->

<div class="panel">

    <h2>Memory Ingest Wing</h2>

    <form method="POST">

        <div class="grid">

            <div class="field">
                <label>Domain</label>
                <select name="domain_id"><?= $domainOptions ?></select>
            </div>

            <div class="field">
                <label>Project</label>
                <select name="project_id"><?= $projectOptions ?></select>
            </div>

            <div class="field">
                <label>AI Source</label>
                <select name="source_ai">
                    <option>ChatGPT</option>
                    <option>Kimi</option>
                    <option>Claude</option>
                    <option>Gemini</option>
                    <option>Grok</option>
                    <option>Cursor</option>
                    <option>Windsurf</option>
                </select>
            </div>

            <div class="field">
                <label>Session Title</label>
                <input name="session_title" type="text">
            </div>

        </div>

        <div class="field full">
            <label>Transcript</label>
            <textarea name="raw_transcript"></textarea>
        </div>

        <button type="submit">INGEST</button>

    </form>

</div>

<!-- =====================================================
     VIEW
===================================================== -->

<div class="panel">

    <h2>Recent Ingested Memory</h2>

    <?php foreach ($rows as $r): ?>

        <div class="item">
            <div><b><?= htmlspecialchars($r['session_title'] ?: 'Untitled') ?></b></div>
            <div class="small">
                <?= htmlspecialchars($r['source_ai']) ?> •
                <?= htmlspecialchars($r['created_at']) ?>
            </div>
        </div>

    <?php endforeach; ?>

</div>

</div>

</body>
</html>