<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Self-learning relation engine running...\n";

/* --------------------------
   LOAD NODES
--------------------------- */
$stmt = $pdo->query("SELECT id, title, project, platform FROM page");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* --------------------------
   LOAD EXISTING RELATIONS
--------------------------- */
$stmt = $pdo->query("
    SELECT source_id, target_id, weight, COALESCE(strength,1) as strength
    FROM page_relations
");

$existing = [];

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    $key = $r['source_id'] . "-" . $r['target_id'];
    $existing[$key] = $r;
}

/* --------------------------
   HELPERS
--------------------------- */
function scoreMatch($a, $b) {
    $aWords = array_filter(explode(" ", strtolower($a)));
    $bWords = array_filter(explode(" ", strtolower($b)));
    return count(array_intersect($aWords, $bWords));
}

/* --------------------------
   UPSERT (LEARNING UPDATE)
--------------------------- */
$upsert = $pdo->prepare("
    INSERT INTO page_relations (source_id, target_id, weight, strength)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        weight = weight + VALUES(weight),
        strength = strength + 0.1,
        last_seen = CURRENT_TIMESTAMP
");

/* --------------------------
   DECAY STEP (FORGOTTEN LINKS)
--------------------------- */
$pdo->exec("
    UPDATE page_relations
    SET strength = strength * 0.98
    WHERE last_seen < (NOW() - INTERVAL 7 DAY)
");

/* --------------------------
   BUILD GRAPH
--------------------------- */
$created = 0;
$updated = 0;

for ($i = 0; $i < count($pages); $i++) {

    for ($j = 0; $j < count($pages); $j++) {

        if ($i == $j) continue;

        $a = $pages[$i];
        $b = $pages[$j];

        $score = 0;

        /* TEXT SIMILARITY */
        $score += scoreMatch($a['title'], $b['title']);

        /* PROJECT BOOST */
        if (!empty($a['project']) && $a['project'] === $b['project']) {
            $score += 3;
        }

        /* PLATFORM BOOST */
        if (!empty($a['platform']) && $a['platform'] === $b['platform']) {
            $score += 2;
        }

        /* THRESHOLD */
        if ($score < 2) continue;

        $key = $a['id'] . "-" . $b['id'];

        if (isset($existing[$key])) {
            $updated++;
            $strength = $existing[$key]['strength'] + 0.1;
        } else {
            $created++;
            $strength = 1;
        }

        $upsert->execute([
            $a['id'],
            $b['id'],
            $score,
            $strength
        ]);
    }
}

echo "New links: $created\n";
echo "Reinforced links: $updated\n";