<?php
require_once "db.php";
require_once __DIR__ . '/lib/semantic_diff_engine.php';
// LOAD PAGES WITH EMBEDDINGS
$stmt = $pdo->query("
    SELECT id, title, embedding, project, platform
    FROM page
    WHERE embedding IS NOT NULL
");

$pages = $stmt->fetchAll();

function cosine($a, $b) {

    $a = json_decode($a, true);
    $b = json_decode($b, true);

    if (!$a || !$b) return 0;

    $dot = 0;
    $magA = 0;
    $magB = 0;

    for ($i = 0; $i < count($a); $i++) {
        $dot += $a[$i] * $b[$i];
        $magA += $a[$i] * $a[$i];
        $magB += $b[$i] * $b[$i];
    }

    return $dot / (sqrt($magA) * sqrt($magB));
}

$update = $pdo->prepare("UPDATE page SET related_ids = ? WHERE id = ?");

foreach ($pages as $p1) {

    $related = [];

    foreach ($pages as $p2) {

        if ($p1['id'] == $p2['id']) continue;

        $score = cosine($p1['embedding'], $p2['embedding']);

        if ($score > 0.78) {
            $related[$p2['id']] = $score;
        }
    }

    arsort($related);
    $top = array_slice(array_keys($related), 0, 5);

    $update->execute([
        implode(",", $top),
        $p1['id']
    ]);
}

echo "Semantic clustering complete.";