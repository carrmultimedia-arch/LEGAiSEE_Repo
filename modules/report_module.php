<?php

kernel_validate_runtime();
require_once __DIR__ . "/../kernel/kernel.php";
require_once __DIR__ . '/../lib/semantic_diff_engine.php';


$pdo = kernel_db();

$total = $pdo->query("SELECT COUNT(*) FROM page")->fetchColumn();
$dir = __DIR__ . "/../normalized/";
$metaFile = $dir . "index_meta.json";

$q = strtolower(trim($_GET['q'] ?? ''));

$a = $_GET['a'] ?? '';
$b = $_GET['b'] ?? '';

$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true) ?: []
    : [];

function loadFile($dir, $file) {
    if (!$file) return "";
    $path = $dir . $file;
    return file_exists($path) ? file_get_contents($path) : "";
}

$contentA = loadFile($dir, $a);
$contentB = loadFile($dir, $b);

$results = [];

foreach ($meta as $key => $m) {

    $content = file_get_contents($dir . $key);

    $haystack = strtolower(($m['file'] ?? '') . " " . $content . " " . ($m['client'] ?? ''));

    if ($q && strpos($haystack, $q) === false) continue;

    $m['key'] = $key;
    $results[] = $m;
}

usort($results, fn($x,$y)=>($y['score'] ?? 0) <=> ($x['score'] ?? 0));

?>

<!-- LEFT COLUMN ONLY (NO WRAPPERS) -->

<form method="GET">
    <input name="q" value="<?=htmlspecialchars($q)?>" placeholder="Search">
    <input type="hidden" name="a" value="<?=htmlspecialchars($a)?>">
    <input type="hidden" name="b" value="<?=htmlspecialchars($b)?>">
    <button>Search</button>
</form>

<?php foreach ($results as $r): ?>

<?php $key = $r['key']; ?>

<div class="card">

    <div class="title"><?=htmlspecialchars($r['file'] ?? $key)?></div>

    <div class="meta">
        Score: <?=round($r['score'] ?? 0,2)?>
    </div>

    <div class="actions">

        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($key)?>&b=<?=urlencode($b)?>">
           Set A
        </a>

        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($a)?>&b=<?=urlencode($key)?>">
           Set B
        </a>

    </div>

</div>

<?php endforeach; ?>