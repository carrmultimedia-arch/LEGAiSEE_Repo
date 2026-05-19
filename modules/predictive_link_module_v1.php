<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

/* ===================================================== */
/* BOOT */
/* ===================================================== */

if (file_exists(__DIR__ . '/utils/bootstrap.php')) {
    require_once __DIR__ . '/utils/bootstrap.php';
}

global $pdo;

/* ===================================================== */
/* LOAD DATA */
/* ===================================================== */

function getEntities(): array
{
    global $pdo;
    return $pdo->query("SELECT * FROM entities")->fetchAll(PDO::FETCH_ASSOC);
}

function getRelationships(): array
{
    global $pdo;
    return $pdo->query("SELECT * FROM relationships")->fetchAll(PDO::FETCH_ASSOC);
}

/* ===================================================== */
/* GRAPH HELPERS */
/* ===================================================== */

function getDegreeMap(array $edges): array
{
    $degree = [];

    foreach ($edges as $e) {

        $a = $e['from_entity'];
        $b = $e['to_entity'];

        $degree[$a] = ($degree[$a] ?? 0) + 1;
        $degree[$b] = ($degree[$b] ?? 0) + 1;
    }

    return $degree;
}

function sharedNeighbors(string $a, string $b, array $edges): int
{
    $mapA = [];
    $mapB = [];

    foreach ($edges as $e) {

        if ($e['from_entity'] === $a || $e['to_entity'] === $a) {
            $mapA[$e['from_entity'] === $a ? $e['to_entity'] : $e['from_entity']] = true;
        }

        if ($e['from_entity'] === $b || $e['to_entity'] === $b) {
            $mapB[$e['from_entity'] === $b ? $e['to_entity'] : $e['from_entity']] = true;
        }
    }

    return count(array_intersect_key($mapA, $mapB));
}

/* ===================================================== */
/* CORE SCORING FUNCTIONS */
/* ===================================================== */

function semanticSimilarity(array $a, array $b): float
{
    if (($a['entity_type'] ?? '') === ($b['entity_type'] ?? '')) {
        return 0.8;
    }

    $compatible = [
        'person' => ['organization', 'company'],
        'company' => ['person', 'product'],
        'event'   => ['organization', 'person']
    ];

    $typeA = $a['entity_type'] ?? '';
    $typeB = $b['entity_type'] ?? '';

    if (isset($compatible[$typeA]) && in_array($typeB, $compatible[$typeA])) {
        return 0.5;
    }

    return 0.2;
}

function clusterAffinity(): float
{
    // placeholder hook → semantic_cluster_module_v1

    return 0.7;
}

function influenceAttraction(array $a, array $b): float
{
    $scoreA = 0.6 + log(1 + (int)$a['id']) / 10;
    $scoreB = 0.6 + log(1 + (int)$b['id']) / 10;

    return ($scoreA + $scoreB) / 2 / 2;
}

/* ===================================================== */
/* MAIN ENGINE */
/* ===================================================== */

$entities = getEntities();
$edges = getRelationships();

$degreeMap = getDegreeMap($edges);

$predictions = [];

$count = count($entities);

for ($i = 0; $i < $count; $i++) {

    for ($j = $i + 1; $j < $count; $j++) {

        $a = $entities[$i];
        $b = $entities[$j];

        $aId = (string)$a['id'];
        $bId = (string)$b['id'];

        // skip if already connected
        foreach ($edges as $e) {
            if (
                ($e['from_entity'] == $aId && $e['to_entity'] == $bId) ||
                ($e['from_entity'] == $bId && $e['to_entity'] == $aId)
            ) {
                continue 2;
            }
        }

        $struct = sharedNeighbors($aId, $bId, $edges);
        $structSim = $struct / max(1, sqrt(($degreeMap[$aId] ?? 1) * ($degreeMap[$bId] ?? 1)));

        $semantic = semanticSimilarity($a, $b);
        $cluster = clusterAffinity();
        $influence = influenceAttraction($a, $b);

        $lps =
            ($structSim * 0.30) +
            ($semantic * 0.30) +
            ($cluster * 0.20) +
            ($influence * 0.20);

        if ($lps > 0.72) {

            $predictions[] = [
                "from" => $aId,
                "to" => $bId,
                "score" => round($lps, 4),
                "structural" => round($structSim, 4),
                "semantic" => round($semantic, 4),
                "cluster" => round($cluster, 4),
                "influence" => round($influence, 4)
            ];
        }
    }
}

/* sort by strongest predictions */
usort($predictions, fn($x, $y) => $y['score'] <=> $x['score']);

/* ===================================================== */
/* OUTPUT */
/* ===================================================== */

return [
    "predicted_links" => array_slice($predictions, 0, 50),
    "total_predictions" => count($predictions)
];