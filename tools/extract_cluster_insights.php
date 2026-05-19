<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Extracting cluster insights...\n";

/* --------------------------
   WORD CLEANER
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
    $projectCount = [];
    $wordCount = [];

    foreach ($rows as $r) {

        /* PLATFORM */
        if (!empty($r['platform'])) {
            $p = strtolower($r['platform']);
            $platformCount[$p] = ($platformCount[$p] ?? 0) + 1;
        }

        /* PROJECT */
        if (!empty($r['project'])) {
            $projectCount[$r['project']] =
                ($projectCount[$r['project']] ?? 0) + 1;
        }

        /* WORDS */
        foreach (words($r['title']) as $w) {
            if (strlen($w) < 4) continue;
            $wordCount[$w] = ($wordCount[$w] ?? 0) + 1;
        }
    }

    arsort($platformCount);
    arsort($projectCount);
    arsort($wordCount);

    $insights = [];

    /* --------------------------
       INSIGHT 1 — PLATFORM DOMINANCE
    --------------------------- */
    $topPlatform = array_key_first($platformCount);

    if ($topPlatform) {
        $pct = round(($platformCount[$topPlatform] / $total) * 100);
        $insights[] = ucfirst($topPlatform) . " dominates this cluster (" . $pct . "% of records)";
    }

    /* --------------------------
       INSIGHT 2 — STRATEGY SIGNALS
    --------------------------- */
    $topWords = array_slice(array_keys($wordCount), 0, 3);

    if ($topWords) {
        $insights[] = "Recurring themes include: " . implode(", ", $topWords);
    }

    /* --------------------------
       INSIGHT 3 — SCALE
    --------------------------- */
    if ($total > 20) {
        $insights[] = "High volume indicates a mature and sustained operational focus";
    } elseif ($total > 8) {
        $insights[] = "Moderate volume suggests consistent execution patterns";
    } else {
        $insights[] = "Low volume indicates emerging or limited activity";
    }

    /* --------------------------
       INSIGHT 4 — PROJECT FOCUS
    --------------------------- */
    $topProject = array_key_first($projectCount);

    if ($topProject && $projectCount[$topProject] > 1) {
        $insights[] = "Primary focus centers around: " . $topProject;
    }

    /* --------------------------
       INSIGHT 5 — BEHAVIOR TYPE
    --------------------------- */
    if (isset($wordCount['promo']) || isset($wordCount['offer'])) {
        $insights[] = "Pattern suggests promotion-driven marketing behavior";
    }

    if (isset($wordCount['brand']) || isset($wordCount['awareness'])) {
        $insights[] = "Indicates brand positioning or awareness campaigns";
    }

    if (isset($wordCount['launch']) || isset($wordCount['new'])) {
        $insights[] = "Signals product or service launch activity";
    }

    /* LIMIT TO TOP 5 */
    $insights = array_slice($insights, 0, 5);

    /* FORMAT */
    $formatted = "";

    foreach ($insights as $i => $text) {
        $formatted .= ($i + 1) . ". " . $text . "\n";
    }

    /* SAVE */
    $stmt = $pdo->prepare("
        UPDATE clusters
        SET insights = ?
        WHERE id = ?
    ");

    $stmt->execute([$formatted, $cid]);

    echo "Cluster $cid insights extracted\n";
}

echo "Done.\n";