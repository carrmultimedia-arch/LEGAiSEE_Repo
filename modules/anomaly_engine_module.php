<?php
declare(strict_types=1);

function anomaly_fetch(string $sql, array $params = []): array {
    try {
        $db   = kernel_db();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        return [];
    }
}

function detectOrphans(): array {
    return anomaly_fetch("SELECT e.* FROM entities e
        LEFT JOIN relationships r ON e.id = r.from_entity OR e.id = r.to_entity
        WHERE r.id IS NULL LIMIT 50");
}

function detectHubs(): array {
    return anomaly_fetch("SELECT e.id, e.canonical_name, COUNT(r.id) AS degree
        FROM entities e
        LEFT JOIN relationships r ON e.id = r.from_entity OR e.id = r.to_entity
        GROUP BY e.id HAVING degree > 25 ORDER BY degree DESC LIMIT 50");
}

function detectWeightAnomalies(): array {
    return anomaly_fetch("SELECT * FROM relationships
        WHERE strength > 0.95
        AND relation_type IN ('weak_signal','uncertain','inferred')
        ORDER BY strength DESC LIMIT 50");
}

function detectAliasExplosion(): array {
    return anomaly_fetch("SELECT e.id, e.canonical_name, COUNT(a.id) AS alias_count
        FROM entities e JOIN entity_aliases a ON e.id = a.entity_id
        GROUP BY e.id HAVING alias_count > 10 ORDER BY alias_count DESC LIMIT 50");
}

function detectContradictions(): array {
    return anomaly_fetch("SELECT r1.from_entity, r1.to_entity,
        r1.relation_type AS type_a, r2.relation_type AS type_b
        FROM relationships r1
        JOIN relationships r2
            ON r1.from_entity = r2.from_entity
            AND r1.to_entity = r2.to_entity
            AND r1.relation_type != r2.relation_type
        LIMIT 50");
}

$orphans   = detectOrphans();
$hubs      = detectHubs();
$weights   = detectWeightAnomalies();
$aliases   = detectAliasExplosion();
$conflicts = detectContradictions();

$riskScore =
    (count($orphans) * 1.2) +
    (count($hubs) * 2.0) +
    (count($weights) * 1.5) +
    (count($aliases) * 2.5) +
    (count($conflicts) * 3.0);

$riskLevel =
    $riskScore > 150 ? "CRITICAL" :
    ($riskScore > 75  ? "HIGH" :
    ($riskScore > 30  ? "MODERATE" : "LOW"));

return [
    "risk_score"             => round($riskScore, 1),
    "risk_level"             => $riskLevel,
    "orphans_detected"       => count($orphans),
    "hub_nodes"              => count($hubs),
    "weight_anomalies"       => count($weights),
    "alias_explosions"       => count($aliases),
    "relationship_conflicts" => count($conflicts),
];