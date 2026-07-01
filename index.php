<?php
/*
<!--TEST--
================================================
LEGAiSEE CONTROL CENTER UI
================================================
*/

$basePath = __DIR__ . "/data/";
$portfolioPath = $basePath . "portfolio/";
$clientsPath = $basePath . "clients/";


/*
================================================
HELPERSss
================================================
*/

function safeRead($file){
    if(file_exists($file)){
        return json_encode(json_decode(file_get_contents($file), true), JSON_PRETTY_PRINT);
    }
    return "File not found.";
}

function listDirRecursive($dir, $base = ""){
    $result = [];

    if(!is_dir($dir)) return $result;

    foreach(scandir($dir) as $item){
        if($item === "." || $item === "..") continue;

        $full = $dir . $item;

        if(is_dir($full)){
            $result[$item] = listDirRecursive($full . "/", $base . $item . "/");
        } else {
            $result[] = $base . $item;
        }
    }

    return $result;
}

/*
================================================
ACTIONS
================================================
*/

$workerOutput = null;

if(isset($_GET['run_worker'])){
    $workerOutput = shell_exec("php " . __DIR__ . "/cli/worker.php 2>&1");
}

/*
================================================
LOAD DATA
================================================
*/

$portfolioFiles = [
    "executive_dashboard" => $portfolioPath . "executive_dashboard.json",
    "predictive_insights" => $portfolioPath . "predictive_insights.json",
    "system_insights" => $portfolioPath . "system_insights.json",
    "memory_evolution" => $portfolioPath . "memory_evolution.json"
];

$clientTree = listDirRecursive($clientsPath);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LEGAiSEE Control Center</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #0f172a;
    color: #e2e8f0;
    margin: 0;
}

.header {
    background: #020617;
    padding: 15px;
    font-size: 20px;
    font-weight: bold;
    border-bottom: 1px solid #1e293b;
}

.container {
    display: flex;
    height: calc(100vh - 60px);
}

.sidebar {
    width: 300px;
    background: #020617;
    border-right: 1px solid #1e293b;
    overflow-y: auto;
    padding: 10px;
}

.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.topbar {
    padding: 10px;
    border-bottom: 1px solid #1e293b;
}

.content {
    display: flex;
    flex: 1;
    overflow: hidden;
}

.panel {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    border-right: 1px solid #1e293b;
}

.panel:last-child {
    border-right: none;
}

button {
    background: #2563eb;
    border: none;
    padding: 8px 12px;
    color: white;
    cursor: pointer;
    margin-right: 5px;
}

button:hover {
    background: #1d4ed8;
}

pre {
    background: #020617;
    padding: 10px;
    font-size: 12px;
    overflow-x: auto;
}

.file {
    cursor: pointer;
    padding: 3px;
}

.file:hover {
    background: #1e293b;
}

.folder {
    font-weight: bold;
    margin-top: 5px;
}
</style>

<script>
function loadFile(path){
    fetch("index.php?view_file=" + encodeURIComponent(path))
    .then(res => res.text())
    .then(data => {
        document.getElementById("fileViewer").innerText = data;
    });
}
</script>

</head>
<body>

<div class="header">🧠 LEGAiSEE Control Center</div>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">

<div class="folder">📂 Portfolio</div>
<?php foreach($portfolioFiles as $name => $file): ?>
<div class="file" onclick="loadFile('<?php echo $file; ?>')">
→ <?php echo $name; ?>
</div>
<?php endforeach; ?>

<div class="folder">📁 Clients</div>

<?php
function renderTree($tree, $prefix = ""){
    foreach($tree as $key => $value){
        if(is_array($value)){
            echo "<div class='folder'>$prefix$key</div>";
            renderTree($value, $prefix . "— ");
        } else {
            echo "<div class='file' onclick=\"loadFile('/home/carrmulti/www/www/commandcenter/data/clients/$value')\">$prefix$value</div>";
        }
    }
}
renderTree($clientTree);
?>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">
<form method="get" style="display:inline;">
<button name="run_worker" value="1">▶ Run Worker</button>
</form>
</div>

<div class="content">

<!-- PANEL 1 -->
<div class="panel">
<h3>📊 Executive Dashboard</h3>
<pre><?php echo safeRead($portfolioFiles['executive_dashboard']); ?></pre>

<h3>🔮 Predictive</h3>
<pre><?php echo safeRead($portfolioFiles['predictive_insights']); ?></pre>
</div>

<!-- PANEL 2 -->
<div class="panel">
<h3>🧠 System Insights</h3>
<pre><?php echo safeRead($portfolioFiles['system_insights']); ?></pre>

<h3>⏳ Memory Evolution</h3>
<pre><?php echo safeRead($portfolioFiles['memory_evolution']); ?></pre>
</div>

<!-- PANEL 3 -->
<div class="panel">
<h3>📄 File Viewer</h3>
<pre id="fileViewer">Click any file on the left</pre>

<h3>⚙ Worker Output</h3>
<pre><?php echo htmlspecialchars($workerOutput); ?></pre>
</div>

</div>
</div>

</div>

<?php
/*
================================================
FILE VIEW HANDLER (AJAX)
================================================
*/
if(isset($_GET['view_file'])){
    $file = $_GET['view_file'];

    if(file_exists($file)){
        echo file_get_contents($file);
    } else {
        echo "File not found.";
    }
    exit;
}
?>

</body>
</html>