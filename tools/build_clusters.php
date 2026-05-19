<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Running cluster detection...\n";

/* --------------------------
   LOAD NODES
--------------------------- */
$stmt = $pdo->query("SELECT id, title, project, platform FROM page");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* --------------------------
   INIT CLUSTERS
--------------------------- */
$clusters = [];
$clusterMap = [];
$clusterId = 1;

/* --------------------------
   SCORE FUNCTION
--------------------------- */
function similarityScore($a, $b) {

    $aWords = array_filter(explode(" ", strtolower($a)));
    $bWords = array_filter(explode(" ", strtolower($b)));

    return count(array_intersect($aWords, $bWords));
}

/* --------------------------
   ASSIGN CLUSTERS
--------------------------- */
foreach ($pages as $page) {

    $assigned = false;

    foreach ($clusters as $cid => $clusterPages) {

        $scoreTotal = 0;
        $count = 0;

        foreach ($clusterPages as $cp) {
            $scoreTotal += similarityScore($page['title'], $cp['title']);
            $count++;
        }

        $avg = $count ? $scoreTotal / $count : 0;

        /* threshold determines cluster membership */
        if ($avg >= 2) {

            $clusters[$cid][] = $page;
            $clusterMap[$page['id']] = $cid;
            $assigned = true;
            break;
        }
    }

    if (!$assigned) {
        $clusters[$clusterId][] = $page;
        $clusterMap[$page['id']] = $clusterId;
        $clusterId++;
    }
}

/* --------------------------
   SAVE TO DB
--------------------------- */
$stmt = $pdo->prepare("
    UPDATE page SET cluster_id = ? WHERE id = ?
");

foreach ($clusterMap as $pageId => $cid) {
    $stmt->execute([$cid, $pageId]);
}

echo "Clusters created: " . count($clusters) . "\n";