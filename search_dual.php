<?php

$baseDir = __DIR__ . "/normalized/";
require_once __DIR__ . '/lib/semantic_diff_engine.php';
if (!is_dir($baseDir)) mkdir($baseDir, 0755, true);

$query = $_GET['q'] ?? "";
$a = $_GET['a'] ?? "";
$b = $_GET['b'] ?? "";

function loadFile($baseDir, $file) {
    if (!$file) return "";
    $path = realpath($baseDir . $file);
    if (!$path || strpos($path, $baseDir) !== 0 || !file_exists($path)) return "";
    return file_get_contents($path);
}

$contentA = loadFile($baseDir, $a);
$contentB = loadFile($baseDir, $b);

$results = [];

if ($query !== "") {
    foreach (scandir($baseDir) as $file) {
        if ($file === "." || $file === "..") continue;
        if (strpos($file, "_state_") !== false) continue;

        $full = $baseDir . $file;
        if (!is_file($full)) continue;

        $content = file_get_contents($full);

        if (stripos($file, $query) !== false || stripos($content, $query) !== false) {
            $results[] = $file;
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dual Compare Intelligence</title>

<style>
* { box-sizing:border-box; margin:0; padding:0; }

body {
    font-family:Segoe UI;
    background:linear-gradient(135deg,#0a0a0f,#1a1a2e);
    color:#e0e0e0;
}

/* HEADER */
.header {
    background:rgba(0,0,0,0.7);
    border-bottom:2px solid #FFD700;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
}

/* LAYOUT */
.wrapper {
    display:flex;
    height:calc(100vh - 80px);
}

/* LEFT SEARCH */
.left {
    width:30%;
    padding:15px;
    border-right:1px solid rgba(255,215,0,0.2);
    overflow:auto;
}

/* RIGHT COMPARE */
.right {
    flex:1;
    display:flex;
    gap:10px;
    padding:15px;
}

/* SEARCH INPUT */
input {
    width:100%;
    padding:10px;
    margin-bottom:10px;
    background:#111;
    border:1px solid #FFD700;
    color:white;
}

button {
    padding:10px;
    background:#FFD700;
    border:none;
    font-weight:bold;
    cursor:pointer;
    width:100%;
}

/* RESULT ITEM */
.item {
    border:1px solid rgba(255,215,0,0.2);
    padding:10px;
    margin-bottom:8px;
    border-radius:6px;
    font-size:13px;
}

.row {
    display:flex;
    gap:5px;
    margin-top:5px;
}

.smallbtn {
    flex:1;
    font-size:11px;
    padding:6px;
    background:#111;
    border:1px solid #FFD700;
    color:#FFD700;
    cursor:pointer;
    text-align:center;
    text-decoration:none;
}

/* PANES */
.pane {
    flex:1;
    display:flex;
    flex-direction:column;
    border:1px solid rgba(255,215,0,0.2);
    background:rgba(255,255,255,0.05);
    border-radius:8px;
    overflow:hidden;
}

/* FIND BAR */
.findbar {
    display:flex;
    gap:5px;
    padding:8px;
    border-bottom:1px solid rgba(255,215,0,0.2);
}

.findbar input {
    margin:0;
    padding:6px;
    font-size:12px;
}

.findbar button {
    width:auto;
    padding:6px 10px;
    font-size:12px;
}

/* SCROLL AREA */
.viewer {
    flex:1;
    overflow:auto;
    padding:15px;
    white-space:pre-wrap;
    font-family:monospace;
    line-height:1.6;
}

/* HIGHLIGHT */
mark {
    background:#FFD700;
    color:#000;
}
</style>
</head>

<body>

<div class="header">
    <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" style="height:50px">

    <div>
        <a href="index.php" style="color:#FFD700;margin-left:10px;">Dashboard</a>
        <a href="search.php" style="color:#FFD700;margin-left:10px;">Search</a>
    </div>
</div>

<div class="wrapper">

<!-- LEFT -->
<div class="left">

<h3 style="color:#FFD700;margin-bottom:10px;">Search</h3>

<form method="GET">
    <input type="text" name="q" value="<?= htmlspecialchars($query) ?>">
    <input type="hidden" name="a" value="<?= htmlspecialchars($a) ?>">
    <input type="hidden" name="b" value="<?= htmlspecialchars($b) ?>">
    <button>Execute</button>
</form>

<?php foreach ($results as $r): ?>

<div class="item">
    <div><?= htmlspecialchars($r) ?></div>

    <div class="row">
        <a class="smallbtn" href="?q=<?= urlencode($query) ?>&a=<?= urlencode($r) ?>&b=<?= urlencode($b) ?>">
            Set A
        </a>

        <a class="smallbtn" href="?q=<?= urlencode($query) ?>&a=<?= urlencode($a) ?>&b=<?= urlencode($r) ?>">
            Set B
        </a>
    </div>
</div>

<?php endforeach; ?>

</div>

<!-- RIGHT -->
<div class="right">

<!-- A -->
<div class="pane">

<div class="findbar">
    <input type="text" placeholder="Find in A" oninput="findIn('a', this.value)">
</div>

<div class="viewer" id="viewerA"><?= htmlspecialchars($contentA ?: "Select A...") ?></div>

</div>

<!-- B -->
<div class="pane">

<div class="findbar">
    <input type="text" placeholder="Find in B" oninput="findIn('b', this.value)">
</div>

<div class="viewer" id="viewerB"><?= htmlspecialchars($contentB ?: "Select B...") ?></div>

</div>

</div>

</div>

<script>
function findIn(panel, term) {

    const el = document.getElementById(panel === 'a' ? 'viewerA' : 'viewerB');

    if (!term) {
        el.innerHTML = el.innerText;
        return;
    }

    const text = el.innerText;
    const regex = new RegExp(term, "gi");

    el.innerHTML = text.replace(regex, match => `<mark>${match}</mark>`);
}
</script>

</body>
</html>