<?php

require_once __DIR__ . "/../bootstrap.php";

/* CLEAN OUTPUT */
if (ob_get_length()) ob_clean();
header('Content-Type: application/json');

try {

/* LOAD CLUSTER NAMES */
$clusterNames = [];

$stmt = $pdo->query("SELECT id, name FROM clusters");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $c) {
    $clusterNames[$c['id']] = $c['name'];
}
    /* --------------------------
       LOAD NODES
    --------------------------- */
    $stmt = $pdo->query("
        SELECT id, title, cluster_id
        FROM page
    ");

    $nodesRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $nodeMap = [];

    foreach ($nodesRaw as $n) {
        $nodeMap[$n['id']] = [
    "id" => (int)$n['id'],
    "title" => $n['title'],
    "cluster" => (int)($n['cluster_id'] ?? 0),
    "cluster_name" => $clusterNames[$n['cluster_id']] ?? "Unlabeled"
        ];
    }

    /* --------------------------
       LOAD LINKS
    --------------------------- */
    $stmt = $pdo->query("
        SELECT source_id, target_id, COALESCE(weight,1) as weight
        FROM page_relations
        WHERE source_id IS NOT NULL
          AND target_id IS NOT NULL
    ");

    $linksRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $links = [];

    foreach ($linksRaw as $l) {

        if (!isset($nodeMap[$l['source_id']]) || !isset($nodeMap[$l['target_id']])) {
            continue;
        }

        $links[] = [
            "source" => (int)$l['source_id'],
            "target" => (int)$l['target_id'],
            "weight" => (int)$l['weight']
        ];
    }

    echo json_encode([
        "nodes" => array_values($nodeMap),
        "links" => $links
    ], JSON_UNESCAPED_SLASHES);

} catch (Throwable $e) {

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}