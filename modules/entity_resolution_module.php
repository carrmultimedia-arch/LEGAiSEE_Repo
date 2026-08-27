<?php
declare(strict_types=1);

require_once __DIR__ . '/../kernel/db.php';

try {
    $pdo = kernel_db();
} catch (Throwable $e) {
    return ['status' => 'error', 'message' => $e->getMessage()];
}

$action   = $_GET['action'] ?? 'status';
$entityId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$case_id = $_GET['case_id'] ?? null;

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
    $insights    = [];
    
    for ($i = 0; $i < count($entities); $i++) {
        for ($j = $i + 1; $j < count($entities); $j++) {
            $comparisons++;
            $eval = evaluateMerge($entities[$i], $entities[$j]);
            if ($eval['should_merge']) { 
                $mergeCount++;
                $insights[] = [
                    'type' => 'entity_merge',
                    'summary' => "Potential merge: {$entities[$i]['canonical_name']} ↔ {$entities[$j]['canonical_name']}",
                    'confidence' => $eval['score'] >= 0.9 ? 'high' : ($eval['score'] >= 0.8 ? 'medium' : 'low'),
                    'created_at' => date('c')
                ];
                break 2;
            }
        }
    }
    
    return [
        'status'           => 'complete',
        'entities_scanned' => count($entities),
        'comparisons'      => $comparisons,
        'merges_executed'  => $mergeCount,
        'insights'         => $insights
    ];
}

function writeInsights(array $insights, string $case_id): bool {
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
    
    $insightsFile = $caseDir . '/insights.json';
    $existingInsights = file_exists($insightsFile) ? json_decode(file_get_contents($insightsFile), true) : [];
    
    // Merge new insights with existing
    $mergedInsights = array_merge($existingInsights, $insights);
    
    return file_put_contents($insightsFile, json_encode($mergedInsights, JSON_PRETTY_PRINT)) !== false;
}

// Handle actions
if ($action === 'scan') {
    $result = runResolutionScan($pdo);
    if ($case_id && !empty($result['insights'])) {
        writeInsights($result['insights'], $case_id);
    }
    return $result;
}

if ($action === 'analyze' && $entityId) {
    $entity = getEntity($pdo, $entityId);
    if (!$entity) return ['status' => 'error', 'message' => 'entity_not_found'];
    
    $candidates = findCandidates($pdo, $entity['canonical_name']);
    $evaluations = [];
    foreach ($candidates as $c) {
        if ($c['id'] !== $entityId) {
            $evaluations[] = [
                'candidate' => $c,
                'evaluation' => evaluateMerge($entity, $c)
            ];
        }
    }
    
    return [
        'status' => 'analyzed',
        'entity' => $entity,
        'candidates' => $evaluations
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