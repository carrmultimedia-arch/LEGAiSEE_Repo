<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Detecting opportunities...\n";

/* --------------------------
   WORD PARSER
--------------------------- */
function words($text) {
    $text = strtolower($text);
    $text = preg_replace("/[^a-z0-9\s]/", "", $text);
    return array_filter(explode(" ", $text));
}

/* --------------------------
   LOAD CLUSTERS
--------------------------- */
$stmt = $pdo->query("SELECT id FROM clusters");
$clusterIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

/* --------------------------
   PROCESS
--------------------------- */
foreach ($clusterIds as $cid) {

    $stmt = $pdo->prepare("
        SELECT title, project, platform
        FROM page
        WHERE cluster_id = ?
    ");
    $stmt->execute([$cid]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) continue;

    $total = count($rows);

    $platformCount = [];
    $wordCount = [];

    foreach ($rows as $r) {

        /* PLATFORM */
        if (!empty($r['platform'])) {
            $p = strtolower($r['platform']);
            $platformCount[$p] = ($platformCount[$p] ?? 0) + 1;
        }

        /* WORDS */
        foreach (words($r['title']) as $w) {
            if (strlen($w) < 4) continue;
            $wordCount[$w] = ($wordCount[$w] ?? 0) + 1;
        }
    }

    arsort($platformCount);
    arsort($wordCount);

    $opportunities = [];

    /* --------------------------
       1. PLATFORM GAPS
    --------------------------- */

    $platforms = array_keys($platformCount);

    if (in_array("facebook", $platforms) && !in_array("instagram", $platforms)) {
        $opportunities[] = "Instagram is not utilized alongside Facebook, limiting audience reach";
    }

    if (!in_array("website", $platforms)) {
        $opportunities[] = "No website or conversion layer detected — potential revenue leakage";
    }

    if (!in_array("youtube", $platforms)) {
        $opportunities[] = "No long-form or video platform strategy detected";
    }

    /* --------------------------
       2. CONTENT STRATEGY GAPS
    --------------------------- */

    if (!isset($wordCount['brand']) && !isset($wordCount['awareness'])) {
        $opportunities[] = "Lack of brand-building content suggests weak long-term positioning";
    }

    if (!isset($wordCount['offer']) && !isset($wordCount['promo'])) {
        $opportunities[] = "No clear promotional strategy detected — missed conversion opportunities";
    }

    if (!isset($wordCount['launch']) && !isset($wordCount['new'])) {
        $opportunities[] = "No launch-related activity detected — potential missed growth cycles";
    }

    /* --------------------------
       3. SCALE OPPORTUNITY
    --------------------------- */

    if ($total < 5) {
        $opportunities[] = "Very low activity volume — significant opportunity for expansion";
    } elseif ($total < 12) {
        $opportunities[] = "Moderate activity — scaling output could increase impact";
    }

    /* --------------------------
       4. DIVERSIFICATION
    --------------------------- */

    if (count($platforms) == 1) {
        $opportunities[] = "Single-platform dependency detected — high strategic risk";
    }

    /* LIMIT */
    $opportunities = array_slice($opportunities, 0, 5);

    /* FORMAT */
    $formatted = "";

    foreach ($opportunities as $i => $text) {
        $formatted .= ($i + 1) . ". " . $text . "\n";
    }

    /* SAVE */
    $stmt = $pdo->prepare("
        UPDATE clusters
        SET opportunities = ?
        WHERE id = ?
    ");

    $stmt->execute([$formatted, $cid]);

    echo "Cluster $cid opportunities detected\n";
}

echo "Done.\n";