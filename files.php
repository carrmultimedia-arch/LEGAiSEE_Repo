<?php

$root = realpath(__DIR__);
$base = $root;

$path = $_GET['path'] ?? '';
$file = $_GET['file'] ?? '';

$fullPath = realpath($base . '/' . $path);
require_once __DIR__ . '/lib/semantic_diff_engine.php';
/* ==========================
   SECURITY
========================== */
if ($fullPath === false || strpos($fullPath, $base) !== 0) {
    $fullPath = $base;
    $path = '';
}

/* ==========================
   SCAN DIRECTORY
========================== */
$items = scandir($fullPath);

/* ==========================
   CURRENT FILE
========================== */
$currentFile = "";
if ($file) {
    $candidate = realpath($base . '/' . $file);
    if ($candidate && strpos($candidate, $base) === 0) {
        $currentFile = $file;
    }
}

/* ==========================
   SAVE FILE
========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveFile'])) {

    $target = realpath($base . '/' . $_POST['file']);

    if ($target && strpos($target, $base) === 0) {
        file_put_contents($target, $_POST['content']);
        echo "SAVED";
    } else {
        echo "ERROR";
    }
    exit;
}

/* ==========================
   RUN INDEXER
========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['runIndex'])) {

    $ch = curl_init("http://localhost/commandcenter/indexer.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
    exit;
}

/* ==========================
   RUN EXCAVATION
========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['runExcavation'])) {

    $target = realpath($base . '/' . $_POST['file']);

    if (!$target || strpos($target, $base) !== 0) {
        echo json_encode(["error"=>"Invalid file"]);
        exit;
    }

    $content = file_get_contents($target);

    $client = "file_intelligence";
    $session_id = "session_" . time();

    $sessionPath = __DIR__ . "/clients/{$client}/excavations/{$session_id}";

    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0777, true);
    }

    file_put_contents(
        $sessionPath . "/session.json",
        json_encode([
            "client"=>$client,
            "session_id"=>$session_id,
            "query"=>substr($content,0,1000),
            "source_file"=>$_POST['file'],
            "created_at"=>date("Y-m-d H:i:s"),
            "status"=>"pending"
        ], JSON_PRETTY_PRINT)
    );

    $payload = json_encode([
        "client"=>$client,
        "session_id"=>$session_id
    ]);

    $ch = curl_init("http://localhost/commandcenter/excavation_engine.php");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    /* AUTO INDEX AFTER EXCAVATION */
    $ch2 = curl_init("http://localhost/commandcenter/indexer.php");
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch2);
    curl_close($ch2);

    echo $response;
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Files</title>

<style>
body {
    font-family:Segoe UI;
    background:linear-gradient(135deg,#0a0a0f,#1a1a2e);
    color:#e0e0e0;
    margin:0;
}

.wrapper {
    display:flex;
    height:100vh;
}

/* LEFT PANEL */
.left {
    width:35%;
    border-right:1px solid rgba(255,215,0,0.2);
    overflow:auto;
}

/* RIGHT PANEL */
.right {
    flex:1;
    display:flex;
    flex-direction:column;
}

/* FILE ITEM */
.item {
    padding:10px;
    border-bottom:1px solid rgba(255,215,0,0.1);
}

.item a {
    color:#FFD700;
    text-decoration:none;
}

/* TOOLBAR */
.toolbar {
    padding:10px;
    border-bottom:1px solid rgba(255,215,0,0.2);
}

/* BUTTONS */
button {
    padding:8px 12px;
    margin-right:5px;
    background:#FFD700;
    border:none;
    cursor:pointer;
    font-weight:bold;
}

/* PREVIEW */
.preview {
    flex:1;
    padding:10px;
    overflow:auto;
    background:#111;
}

/* EDITOR */
textarea {
    width:100%;
    height:300px;
    background:#000;
    color:#0f0;
    font-family:monospace;
}

/* OUTPUT */
.output {
    height:200px;
    overflow:auto;
    background:#000;
    color:#0f0;
    padding:10px;
}
</style>
</head>

<body>

<div class="wrapper">

<!-- LEFT FILE NAV -->
<div class="left">

<?php if ($path): ?>
<div class="item">
<a href="?path=<?php echo urlencode(dirname($path)); ?>">⬆ Up</a>
</div>
<?php endif; ?>

<?php foreach ($items as $item): ?>
<?php if ($item === '.' || $item === '..') continue; ?>

<?php
$relative = ($path ? $path.'/' : '') . $item;
$full = $fullPath . '/' . $item;
$isDir = is_dir($full);
?>

<div class="item">

<?php if ($isDir): ?>
<a href="?path=<?php echo urlencode($relative); ?>">
📁 <?php echo htmlspecialchars($item); ?>
</a>
<?php else: ?>
<a href="?path=<?php echo urlencode($path); ?>&file=<?php echo urlencode($relative); ?>">
📄 <?php echo htmlspecialchars($item); ?>
</a>
<?php endif; ?>

</div>

<?php endforeach; ?>

</div>

<!-- RIGHT PANEL -->
<div class="right">

<div class="toolbar">

<button onclick="runIndex()">Index All</button>

<?php if ($currentFile): ?>
<button onclick="saveFile()">Save</button>
<button onclick="runExcavation()">Run Excavation</button>
<?php endif; ?>

</div>

<div class="preview" id="preview">

<?php

if ($currentFile) {

    $ext = strtolower(pathinfo($currentFile, PATHINFO_EXTENSION));
    $filePath = $base . '/' . $currentFile;

    if (in_array($ext, ['txt','md','json','php','html','css','js'])) {

        echo "<textarea id='editor'>" . htmlspecialchars(file_get_contents($filePath)) . "</textarea>";

    } elseif (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {

        echo "<img src='" . htmlspecialchars($currentFile) . "' style='max-width:100%;'>";

    } else {

        echo "Preview not available.<br>";
        echo "<a href='" . htmlspecialchars($currentFile) . "' target='_blank'>Open File</a>";
    }

} else {

    echo "Select a file.";

}

?>

</div>

<div class="output" id="output"></div>

</div>

</div>

<script>

function saveFile() {

    const content = document.getElementById("editor").value;

    fetch('', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'saveFile=1&file=<?php echo urlencode($currentFile); ?>&content=' + encodeURIComponent(content)
    })
    .then(r=>r.text())
    .then(d=>{
        document.getElementById('output').innerText = d;
    });
}

function runExcavation() {

    fetch('', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'runExcavation=1&file=<?php echo urlencode($currentFile); ?>'
    })
    .then(r=>r.text())
    .then(d=>{
        document.getElementById('output').innerText = d;
    });
}

function runIndex() {

    fetch('', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'runIndex=1'
    })
    .then(r=>r.text())
    .then(d=>{
        document.getElementById('output').innerText = d;
    });
}

</script>

</body>
</html>