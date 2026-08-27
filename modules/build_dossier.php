<?php
declare(strict_types=1);

/**
 * LEGAiSEE Business Archaeology Compiler
 *
 * Receives selected artifact IDs from report_module.php
 * Compiles memory_ingest records into a dossier.
 */

require_once __DIR__ . '/../kernel/kernel_boot.php';

if (!kernel_validate_runtime()) {
    die("Kernel failed to initialize.");
}

$db = kernel_db();


$query = trim($_POST['query'] ?? '');

$ids = $_POST['ids'] ?? [];


if (empty($ids) || !is_array($ids)) {
    die("No artifacts selected.");
}


$ids = array_map('intval', $ids);


$placeholders = implode(',', array_fill(0, count($ids), '?'));


$sql = "
SELECT
    id,
    source_ai,
    session_title,
    raw_transcript,
    word_count,
    created_at
FROM memory_ingest
WHERE id IN ($placeholders)
ORDER BY created_at ASC
";


$stmt = $db->prepare($sql);
$stmt->execute($ids);


$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



$totalWords = 0;
$artifacts = [];


foreach ($results as $r) {

    $text = $r['raw_transcript'] ?? '';

    $words = str_word_count($text);

    $totalWords += $words;


    $artifacts[] = [

        'file'  => $r['session_title'] ?: 'Untitled Artifact',

        'key'   => $r['id'],

        'score' => $r['source_ai'] ?? '',

        'words' => $words,

        'text'  => $text

    ];
}



$combined = '';

foreach ($artifacts as $a) {
    $combined .= "\n" . $a['text'];
}



preg_match_all(
    '/\b[A-Z][A-Za-z0-9&\.]+\b/',
    $combined,
    $matches
);


$entities = array_unique($matches[0] ?? []);

sort($entities);


?>
<!DOCTYPE html>
<html>
<head>

<title>
<?=htmlspecialchars($query)?> - Business Archaeology Dossier
</title>

<link rel="stylesheet" href="/commandcenter/ui/global.css">

<style>

body {
    padding:40px;
}

.card {

    background:#1b1b22;
    padding:20px;
    margin-bottom:25px;
    border-radius:8px;

}

pre {

white-space:pre-wrap;

}

.meta {

color:#aaa;

}

</style>

</head>


<body>


<div class="card">

<h1>
Business Archaeology Dossier
</h1>

<h2>
<?=htmlspecialchars($query)?>
</h2>


<p>
Compiled from <?=count($artifacts)?> artifacts containing <?=number_format($totalWords)?> words.
</p>

</div>



<div class="card">

<h2>
Artifact Inventory
</h2>


<ul>

<?php foreach($artifacts as $a): ?>

<li>

<strong>
<?=htmlspecialchars($a['file'])?>
</strong>

(
<?=$a['words']?> words
)

</li>

<?php endforeach; ?>

</ul>

</div>




<div class="card">

<h2>
Extracted Entities
</h2>

<p>

<?=htmlspecialchars(
implode(', ', array_slice($entities,0,100))
)?>

</p>

</div>



<h1>
Archive Artifacts
</h1>



<?php foreach($artifacts as $i=>$a): ?>


<div class="card">

<h2>
Artifact <?=($i+1)?>
</h2>


<div class="meta">

Source:
<?=htmlspecialchars($a['file'])?>

<br>

AI Source:
<?=htmlspecialchars($a['score'])?>

</div>


<pre>

<?=htmlspecialchars($a['text'])?>

</pre>


</div>


<?php endforeach; ?>


</body>
</html>