<?php

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

    $content = file_exists($dir . $key) ? file_get_contents($dir . $key) : "";

    $haystack = strtolower(($m['file'] ?? '') . " " . $content . " " . ($m['client'] ?? ''));

    if ($q && strpos($haystack, $q) === false) continue;

    $m['key'] = $key;
    $results[] = $m;
}

usort($results, fn($x,$y)=>($y['score'] ?? 0) <=> ($x['score'] ?? 0));
?>

<div class="flex">

<!-- LEFT COLUMN -->
<div class="left-col">

<form method="GET">
<input type="hidden" name="page" value="search">
<input name="q" value="<?=htmlspecialchars($q)?>">
<input type="hidden" name="a" value="<?=htmlspecialchars($a)?>">
<input type="hidden" name="b" value="<?=htmlspecialchars($b)?>">
</form>

<?php foreach ($results as $r): ?>

<?php $key = $r['key']; $isA = ($a === $key); $isB = ($b === $key); ?>

<div class="card">

<div><?=htmlspecialchars($r['file'] ?? $key)?></div>

<div style="font-size:11px; color:#aaa;">
Score: <?=round($r['score'] ?? 0,2)?>
</div>

<div style="margin-top:5px;">

<a href="?page=search&q=<?=urlencode($q)?>&a=<?= $isA ? '' : urlencode($key) ?>&b=<?=urlencode($b)?>">
<?= $isA ? "Clear A" : "Set A" ?>
</a>

<a href="?page=search&q=<?=urlencode($q)?>&a=<?=urlencode($a)?>&b=<?= $isB ? '' : urlencode($key) ?>">
<?= $isB ? "Clear B" : "Set B" ?>
</a>

</div>

</div>

<?php endforeach; ?>

</div>

<!-- RIGHT COLUMN -->
<div class="column">

<div class="flex">

<div class="column">
<div class="card">
<pre><?=htmlspecialchars($contentA ?: "Select A")?></pre>
</div>
</div>

<div class="column">
<div class="card">
<pre><?=htmlspecialchars($contentB ?: "Select B")?></pre>
</div>
</div>

</div>

</div>

</div>