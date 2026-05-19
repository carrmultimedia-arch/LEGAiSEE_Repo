<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Running cluster naming...\n";

/* --------------------------
   LOAD CLUSTER DATA
--------------------------- */
$stmt = $pdo->query("
    SELECT cluster_id, title, project, platform
    FROM page
    WHERE cluster_id IS NOT NULL
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* --------------------------
   GROUP BY CLUSTER
--------------------------- */
$clusters = [];

foreach ($rows as $r) {
    $clusters[$r['cluster_id']][] = $r;
}

/* --------------------------
   WORD EXTRACTION
--------------------------- */
function extractWords($text) {
    $text = strtolower($text);
    $text = preg_replace("/[^a-z0-9\s]/", "", $text);
    return array_filter(explode(" ", $text));
}

/* --------------------------
   BUILD NAMES
--------------------------- */
$names = [];

foreach ($clusters as $cid => $items) {

    $wordCount = [];
    $projectCount = [];
    $platformCount = [];

    foreach ($items as $item) {

        /* TITLE WORDS */
        foreach (extractWords($item['title']) as $w) {
            if (strlen($w) < 4) continue;
            $wordCount[$w] = ($wordCount[$w] ?? 0) + 1;
        }

        /* PROJECT */
        if (!empty($item['project'])) {
            $projectCount[$item['project']] =
                ($projectCount[$item['project']] ?? 0) + 1;
        }

        /* PLATFORM */
        if (!empty($item['platform'])) {
            $platformCount[$item['platform']] =
                ($platformCount[$item['platform']] ?? 0) + 1;
        }
    }

    /* SORT */
    arsort($wordCount);
    arsort($projectCount);
    arsort($platformCount);

    $topWords = array_slice(array_keys($wordCount), 0, 2);
    $topProject = array_key_first($projectCount);
    $topPlatform = array_key_first($platformCount);

    /* BUILD NAME */
    $nameParts = [];

    if ($topProject) $nameParts[] = $topProject;
    if ($topPlatform) $nameParts[] = $topPlatform;

    foreach ($topWords as $w) {
        $nameParts[] = ucfirst($w);
    }

    $finalName = implode(" ", $nameParts);

    if (!$finalName) {
        $finalName = "Cluster " . $cid;
    }

    $names[$cid] = $finalName;
}

/* --------------------------
   SAVE
--------------------------- */
$stmt = $pdo->prepare("
    INSERT INTO clusters (id, name)
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE name = VALUES(name)
");

foreach ($names as $cid => $name) {
    $stmt->execute([$cid, $name]);
}

echo "Clusters named: " . count($names) . "\n";