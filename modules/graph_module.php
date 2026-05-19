<?php
declare(strict_types=1);

if (!class_exists('GraphModule')) {

class GraphModule
{
    public static function query(PDO $db, array $params): array
    {
        $start   = $params['start_entity'] ?? null;
        $maxHops = (int)($params['hops'] ?? 3);
        $limit   = (int)($params['limit'] ?? 20);

        if (!$start) return ['status'=>'error','message'=>'start_entity required'];

        $maxHops     = max(2, min(5, $maxHops));
        $startEntity = self::getEntity($db, $start);

        if (!$startEntity) return ['status'=>'error','message'=>'entity_not_found'];

        $paths  = self::traverse($db, $startEntity['id'], $maxHops);
        $ranked = self::rankPaths($paths);

        return [
            'status'       => 'ok',
            'start_entity' => $startEntity,
            'hops'         => $maxHops,
            'results'      => array_slice($ranked, 0, $limit)
        ];
    }

    private static function getEntity(PDO $db, string $name): ?array
    {
        $stmt = $db->prepare("SELECT id, canonical_name, entity_type FROM entities WHERE canonical_name = ? LIMIT 1");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private static function traverse(PDO $db, int $startId, int $maxHops): array
    {
        $paths    = [];
        $frontier = [['node'=>$startId,'path'=>[$startId],'score'=>1.0,'depth'=>0]];

        while (!empty($frontier)) {
            $current   = array_shift($frontier);
            if ($current['depth'] >= $maxHops) { $paths[] = $current; continue; }
            $neighbors = self::getNeighbors($db, $current['node']);
            foreach ($neighbors as $n) {
                if (in_array($n['to_id'], $current['path'], true)) continue;
                $frontier[] = [
                    'node'  => $n['to_id'],
                    'path'  => array_merge($current['path'], [$n['to_id']]),
                    'score' => self::scoreEdge($current['score'], $n['strength'], $current['depth']),
                    'depth' => $current['depth'] + 1
                ];
            }
            $paths[] = $current;
        }
        return $paths;
    }

    private static function getNeighbors(PDO $db, int $nodeId): array
    {
        $stmt = $db->prepare("SELECT from_entity, to_entity, strength, relation_type FROM relationships WHERE from_entity = ?");
        $stmt->execute([$nodeId]);
        $out = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $toId = self::resolveEntityId($db, $r['to_entity']);
            if (!$toId) continue;
            $out[] = ['from_id'=>$nodeId,'to_id'=>$toId,'strength'=>(float)$r['strength'],'type'=>$r['relation_type']];
        }
        return $out;
    }

    private static function resolveEntityId(PDO $db, string $name): ?int
    {
        $stmt = $db->prepare("SELECT id FROM entities WHERE canonical_name = ? LIMIT 1");
        $stmt->execute([$name]);
        $id = $stmt->fetchColumn();
        return $id ? (int)$id : null;
    }

    private static function scoreEdge(float $score, float $weight, int $depth): float
    {
        return $score * $weight * pow(0.82, $depth + 1);
    }

    private static function rankPaths(array $paths): array
    {
        $grouped = [];
        foreach ($paths as $p) {
            $key = implode('-', $p['path']);
            if (!isset($grouped[$key]) || $p['score'] > $grouped[$key]['score']) $grouped[$key] = $p;
        }
        usort($grouped, fn($a,$b) => $b['score'] <=> $a['score']);
        return array_map(fn($p) => ['path'=>$p['path'],'score'=>round($p['score'],6),'depth'=>$p['depth']], $grouped);
    }
}

} // end class_exists check

// Standalone vs shell.php module
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    try {
        $db = kernel_db();
        header('Content-Type: application/json');
        echo json_encode(GraphModule::query($db, $_GET), JSON_PRETTY_PRINT);
    } catch (Throwable $e) {
        echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
    }
} else {
    try {
        $db       = kernel_db();
        $entities = $db->query("SELECT COUNT(*) FROM entities")->fetchColumn();
        $relations= $db->query("SELECT COUNT(*) FROM relationships")->fetchColumn();
        return ['Entities' => $entities, 'Relationships' => $relations];
    } catch (Throwable $e) {
        return ['Error' => $e->getMessage()];
    }
}