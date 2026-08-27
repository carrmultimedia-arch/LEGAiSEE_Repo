<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

/* ===================================================== */
/* BOOT */
/* ===================================================== */

require_once __DIR__ . '/../db.php';

global $pdo;

$case_id = $_GET['case_id'] ?? null;

/* ===================================================== */
/* LOAD GRAPH */
/* ===================================================== */

function getEntities(): array
{
    global $pdo;
    return $pdo->query("SELECT * FROM entities")->fetchAll(PDO::FETCH_ASSOC);
}

function getEdges(): array
{
    global $pdo;

    return $pdo->query("
        SELECT *
        FROM relationships
    ")->fetchAll(PDO::FETCH_ASSOC);
}

/* ===================================================== */
/* EDGE WEIGHT MODEL */
/* ===================================================== */

function edgeWeight(array $edge): float
{
    $strength = (float)($edge['strength'] ?? 0.5);

    $confidence = 0.7; // placeholder until ingestion v3

    $boost = match ($edge['relation_type'] ?? '') {
        'owns' => 1.4,
        'alias' => 1.5,
        'derived' => 1.2,
        'conflict' => 0.6,
        default => 1.0
    };

    return $strength * $confidence * $boost;
}

/* ===================================================== */
/* INFLUENCE SCORE (FROM GRAPH SCORING V2) */
/* ===================================================== */

function influenceScore(array $entity): float
{
    // placeholder hook into graph_scoring_module_v2

    return 0.6 + (log(1 + (int)$entity['id']) / 10);
}

/* ===================================================== */
/* CLUSTER INITIALIZATION */
/* ===================================================== */

$entities = getEntities();
$edges = getEdges();

$clusters = [];
$entityCluster = [];

/* init */
foreach ($entities as $e) {
    $entityCluster[$e['id']] = $e['id'];
}

/* ===================================================== */
/* PROPAGATION LOOP */
/* ===================================================== */

for ($i = 0; $i < 6; $i++) {

    $changes = 0;

    foreach ($entities as $entity) {

        $bestCluster = $entityCluster[$entity['id']];
        $bestScore = 0;

        foreach ($edges as $edge) {

            if ($edge['from_entity'] != $entity['id']
             && $edge['to_entity'] != $entity['id']) {
                continue;
            }

            $neighborId = ($edge['from_entity'] == $entity['id'])
                ? $edge['to_entity']
                : $edge['from_entity'];

            $weight = edgeWeight($edge);
            $influence = influenceScore($entity);

            $neighborCluster = $entityCluster[$neighborId] ?? $neighborId;

            $score = $weight * $influence;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestCluster = $neighborCluster;
            }
        }

        if ($bestCluster !== $entityCluster[$entity['id']]) {
            $entityCluster[$entity['id']] = $bestCluster;
            $changes++;
        }
    }

    if ($changes < 3) {
        break; // stabilized
    }
}

/* ===================================================== */
/* BUILD CLUSTERS */
/* ===================================================== */

foreach ($entityCluster as $entityId => $clusterId) {
    $clusters[$clusterId][] = $entityId;
}

/* ===================================================== */
/* SCORE CLUSTERS */
/* ===================================================== */

$output = [];

foreach ($clusters as $clusterId => $members) {

    $size = count($members);

    $density = min(1, $size / 25);

    $purity = 0.7; // placeholder until entity_type distribution analysis

    $cohesion = 0.65; // placeholder until full intra-cluster edge scan

    $score = ($cohesion * 0.4) + ($density * 0.4) + ($purity * 0.2);

    $output[] = [
        "cluster_id" => $clusterId,
        "size" => $size,
        "cohesion" => $cohesion,
        "density" => $density,
        "purity" => $purity,
        "cluster_score" => round($score, 4),
        "members" => $members
    ];
}

/* sort */
usort($output, fn($a, $b) => $b['cluster_score'] <=> $a['cluster_score']);

/* ===================================================== */
/* WRITE CLUSTERS TO CASE FILE
/* ===================================================== */

function writeClusters(array $clusters, string $case_id): bool {
    if (!$case_id) return false;
    
    // Find case directory
    $caseDir = null;
    $clientsDir = __DIR__ . '/../data/clients';
    
    foreach (glob($clientsDir . '/*/cases/*', GLOB_ONLYDIR) as $dir) {
        if (basename($dir) === $case_id) {
            $caseDir = $dir;
            break;
        }
    }
    
    if (!$caseDir) return false;
    
    $clustersFile = $caseDir . '/clusters.json';
    
    // Convert to schema format
    $schemaClusters = [];
    foreach ($clusters as $cluster) {
        $clusterName = 'cluster_' . $cluster['cluster_id'];
        $members = [];
        foreach ($cluster['members'] as $memberId) {
            $members[] = [
                'id' => 'n_' . $memberId,
                'type' => 'signal',
                'strength' => 100,
                'content' => "Entity ID: {$memberId}",
                'created_at' => date('c')
            ];
        }
        $schemaClusters[$clusterName] = $members;
    }
    
    return file_put_contents($clustersFile, json_encode($schemaClusters, JSON_PRETTY_PRINT)) !== false;
}

// Write clusters if case_id provided
if ($case_id && !empty($output)) {
    writeClusters($output, $case_id);
}

/* ===================================================== */
/* RETURN
/* ===================================================== */

return [
    "clusters" => $output,
    "total_clusters" => count($output)
];