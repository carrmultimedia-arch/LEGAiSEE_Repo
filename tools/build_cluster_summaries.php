<?php

require_once __DIR__ . "/../bootstrap.php";

echo "Running local intelligence summaries...\n";

/* --------------------------
   LOAD CLUSTERS
--------------------------- */
$stmt = $pdo->query("SELECT id FROM clusters");
$clusterIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

/* --------------------------
   WORD PARSER
--------------------------- */
function words($text) {
    $text = strtolower($text);
    $text = preg_replace("/[^a-z0-9\s]/", "", $text);
    return array_filter(explode(" ", $text));
}

/* --------------------------
   BUILD SUMMARY
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

    $wordCount = [];
    $projectCount = [];
    $platformCount = [];

    foreach ($rows as $r) {

        foreach (words($r['title']) as $w) {
            if (strlen($w) < 4) continue;
            $wordCount[$w] = ($wordCount[$w] ?? 0) + 1;
        }

        if (!empty($r['project'])) {
            $projectCount[$r['project']] =
                ($projectCount[$r['project']] ?? 0) + 1;
        }

        if (!empty($r['platform'])) {
            $platformCount[$r['platform']] =
                ($platformCount[$r['platform']] ?? 0) + 1;
        }
    }

    arsort($wordCount);
    arsort($projectCount);
    arsort($platformCount);

    $topWords = array_slice(array_keys($wordCount), 0, 5);
    $topProject = array_key_first($projectCount);
    $topPlatform = array_key_first($platformCount);

    $count = count($rows);

    /* --------------------------
       INTELLIGENCE BUILD
    --------------------------- */

    $summaryParts = [];

    // Core theme
    if ($topPlatform && $topProject) {
        $summaryParts[] = "This cluster centers on {$topPlatform} activity within {$topProject}";
    } elseif ($topPlatform) {
        $summaryParts[] = "This cluster represents {$topPlatform}-focused activity";
    } else {
        $summaryParts[] = "This cluster represents a recurring operational theme";
    }

    // Pattern layer
    if ($topWords) {
        $summaryParts[] = "Common elements include " . implode(", ", $topWords);
    }

    // Scale interpretation
    if ($count > 15) {
        $summaryParts[] = "The volume of records indicates a sustained and strategic focus area";
    } elseif ($count > 5) {
        $summaryParts[] = "The pattern appears repeatedly, suggesting consistent execution";
    } else {
        $summaryParts[] = "This appears to be a smaller or emerging pattern";
    }

    // Strategic meaning
    if ($topPlatform === "facebook") {
        $summaryParts[] = "This likely reflects audience acquisition or paid media experimentation";
    } elseif ($topPlatform === "instagram") {
        $summaryParts[] = "This suggests visual brand positioning or engagement-driven content";
    } elseif ($topPlatform === "website") {
        $summaryParts[] = "This indicates owned asset development or conversion-focused activity";
    }

    // Final join
    $summary = implode(". ", $summaryParts) . ".";

    /* --------------------------
       SAVE
    --------------------------- */
    $stmt = $pdo->prepare("
        UPDATE clusters
        SET summary = ?
        WHERE id = ?
    ");

    $stmt->execute([$summary, $cid]);

    echo "Cluster $cid summarized\n";
}

echo "Done.\n";