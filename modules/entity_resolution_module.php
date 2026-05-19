<?php
declare(strict_types=1);

// Use kernel_db() — replaces $pdo check
try {
    $pdo = kernel_db();
} catch (Throwable $e) {
    return ['status' => 'error', 'message' => $e->getMessage()];
}

$action   = $_GET['action'] ?? 'status';
$entityId = isset($_GET['id']) ? (int)$_GET['id'] : null;

function normalize(string $text): string {
    return preg_replace('/\s+/', ' ', strtolower(trim($text)));
}

function hashEntity(string $name): string {
    return hash('sha256', normalize($name));
}

function getEntity(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM entities WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function findCandidates(PDO $pdo, string $name): array {
    $stmt = $pdo->prepare("SELECT * FROM entities
        WHERE normalized_hash = ? OR canonical_name LIKE ? LIMIT 50");
    $stmt->execute([hashEntity($name), '%' . $name . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function similarityScore(string $a, string $b): float {
    $a = normalize($a); $b = normalize($b);
    if ($a === $b) return 1.0;
    similar_text($a, $b, $percent);
    return $percent / 100;
}

function evaluateMerge(array $source, array $target): array {
    $nameScore       = similarityScore($source['canonical_name'], $target['canonical_name']);
    $typeMatch       = ($source['entity_type'] === $target['entity_type']) ? 0.2 : 0.0;
    $confidenceDelta = abs((float)$source['confidence'] - (float)$target['confidence']);
    $confidenceScore = max(0, 1 - $confidenceDelta);
    $finalScore      = ($nameScore * 0.7) + ($confidenceScore * 0.2) + ($typeMatch * 0.1);
    return [
        'score'        => $finalScore,
        'name_score'   => $nameScore,
        'should_merge' => $finalScore >= 0.82
    ];
}

function runResolutionScan(PDO $pdo): array {
    $entities    = $pdo->query("SELECT * FROM entities ORDER BY created_at DESC LIMIT 500")->fetchAll(PDO::FETCH_ASSOC);
    $mergeCount  = 0;
    $comparisons = 0;
    for ($i = 0; $i < count($entities); $i++) {
        for ($j = $i + 1; $j < count($entities); $j++) {
            $comparisons++;
            $eval = evaluateMerge($entities[$i], $entities[$j]);
            if ($eval['should_merge']) { $mergeCount++; break 2; }
        }
    }
    return [
        'status'           => 'complete',
        'entities_scanned' => count($entities),
        'comparisons'      => $comparisons,
        'merges_executed'  => $mergeCount
    ];
}

// Default view — just show status, don't auto-run scan
$total = $pdo->query("SELECT COUNT(*) FROM entities")->fetchColumn();
$aliases = $pdo->query("SELECT COUNT(*) FROM entity_aliases")->fetchColumn();

return [
    'status'        => 'ready',
    'entities'      => $total,
    'aliases'       => $aliases,
    'actions'       => '?action=scan | ?action=analyze&id=N | ?action=resolve_one&id=N'
];