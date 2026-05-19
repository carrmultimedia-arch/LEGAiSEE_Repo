<?php

require_once __DIR__ . '/../db.php';

/*
|--------------------------------------------------------------------------
| SEMANTIC DIFF ENGINE v1
|--------------------------------------------------------------------------
| Compares two entity IDs (pages/files/etc)
| Returns structured intelligence diff + executive summary
*/

function semantic_diff(int $a_id, int $b_id): array
{
    global $pdo;

    $a = fetch_entity($a_id);
    $b = fetch_entity($b_id);

    if (!$a || !$b) {
        return [
            'error' => 'ENTITY_NOT_FOUND'
        ];
    }

    $diff = [
        'a' => $a,
        'b' => $b,
        'changes' => [],
        'semantic_shift' => 0,
        'importance_score' => 0,
        'summary' => ''
    ];

    /* -----------------------------
       1. TITLE SHIFT
    ----------------------------- */
    if ($a['title'] !== $b['title']) {
        $diff['changes'][] = [
            'type' => 'title_change',
            'a' => $a['title'],
            'b' => $b['title'],
            'weight' => 0.3
        ];
    }

    /* -----------------------------
       2. SUMMARY SHIFT (semantic signal)
    ----------------------------- */
    $summary_delta = semantic_similarity_score(
        $a['summary'],
        $b['summary']
    );

    $diff['semantic_shift'] += (1 - $summary_delta);

    if ($summary_delta < 0.75) {
        $diff['changes'][] = [
            'type' => 'meaning_drift',
            'score' => $summary_delta,
            'weight' => 0.6
        ];
    }

    /* -----------------------------
       3. TAG DIFFERENCE
    ----------------------------- */
    $tags_a = json_decode($a['tags'] ?? '[]', true);
    $tags_b = json_decode($b['tags'] ?? '[]', true);

    $added = array_values(array_diff($tags_b, $tags_a));
    $removed = array_values(array_diff($tags_a, $tags_b));

    if ($added || $removed) {
        $diff['changes'][] = [
            'type' => 'tag_delta',
            'added' => $added,
            'removed' => $removed,
            'weight' => 0.4
        ];
    }

    /* -----------------------------
       4. RELATION SHIFT
    ----------------------------- */
    $rel_a = json_decode($a['related_ids'] ?? '[]', true);
    $rel_b = json_decode($b['related_ids'] ?? '[]', true);

    $rel_delta = count(array_diff($rel_a, $rel_b)) + count(array_diff($rel_b, $rel_a));

    if ($rel_delta > 0) {
        $diff['changes'][] = [
            'type' => 'relationship_shift',
            'delta' => $rel_delta,
            'weight' => 0.5
        ];
    }

    /* -----------------------------
       5. CLUSTER DRIFT
    ----------------------------- */
    if ($a['cluster_id'] !== $b['cluster_id']) {
        $diff['changes'][] = [
            'type' => 'cluster_shift',
            'from' => $a['cluster_id'],
            'to' => $b['cluster_id'],
            'weight' => 0.9
        ];
    }

    /* -----------------------------
       6. FINAL SCORING
    ----------------------------- */
    $diff['importance_score'] = calculate_importance($diff['changes']);

    $diff['summary'] = generate_executive_summary($diff);

    return $diff;
}
/* -----------------------------
       7. Dif Engine
    ----------------------------- */
function fetch_entity(int $id): ?array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            id,
            title,
            ai_summary,
            ai_tags,
            related_ids,
            cluster_id,
            embedding
        FROM page
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    return [
        'id' => (int)$row['id'],
        'title' => (string)$row['title'],
        'summary' => (string)($row['ai_summary'] ?? ''),
        'tags' => json_decode($row['ai_tags'] ?? '[]', true) ?: [],
        'related_ids' => json_decode($row['related_ids'] ?? '[]', true) ?: [],
        'cluster_id' => $row['cluster_id'] !== null ? (int)$row['cluster_id'] : null,
        'embedding' => json_decode($row['embedding'] ?? '[]', true) ?: []
    ];
}
function semantic_similarity_score(string $a, string $b): float
{
    $a = strtolower(trim($a));
    $b = strtolower(trim($b));

    if ($a === '' || $b === '') return 0.0;
    if ($a === $b) return 1.0;

    $a_words = array_filter(explode(' ', preg_replace('/[^a-z0-9\s]/', '', $a)));
    $b_words = array_filter(explode(' ', preg_replace('/[^a-z0-9\s]/', '', $b)));

    $a_words = array_unique($a_words);
    $b_words = array_unique($b_words);

    if (!$a_words || !$b_words) return 0.0;

    $intersection = array_intersect($a_words, $b_words);
    $union = array_unique(array_merge($a_words, $b_words));

    $jaccard = count($intersection) / max(count($union), 1);

    return round($jaccard, 4);
}
function calculate_importance(array $changes): float
{
    $weights = [
        'title_change'        => 0.2,
        'meaning_drift'       => 0.6,
        'tag_delta'           => 0.3,
        'relationship_shift'  => 0.4,
        'cluster_shift'       => 0.9
    ];

    $score = 0.0;

    foreach ($changes as $change) {
        $type = $change['type'] ?? null;

        if (!$type || !isset($weights[$type])) {
            continue;
        }

        $score += $weights[$type];
    }

    return min(1.0, round($score, 4));
}

function generate_executive_summary(array $diff): string
{
    $out = [];

    $out[] = "SEMANTIC DIFF REPORT";
    $out[] = "--------------------";
    $out[] = "Impact Score: " . round($diff['importance_score'] * 100) . "%";
    $out[] = "";

    foreach ($diff['changes'] as $c) {

        switch ($c['type']) {

            case 'title_change':
                $out[] = "TITLE SHIFT:";
                $out[] = "- FROM: " . $c['a'];
                $out[] = "- TO:   " . $c['b'];
                break;

            case 'meaning_drift':
                $out[] = "MEANING DRIFT:";
                $out[] = "- similarity score: " . $c['score'];
                break;

            case 'tag_delta':
                $out[] = "TAG CHANGE:";
                $out[] = "- added: " . implode(', ', $c['added'] ?? []);
                $out[] = "- removed: " . implode(', ', $c['removed'] ?? []);
                break;

            case 'relationship_shift':
                $out[] = "RELATIONSHIP SHIFT:";
                $out[] = "- delta: " . $c['delta'];
                break;

            case 'cluster_shift':
                $out[] = "CLUSTER MIGRATION:";
                $out[] = "- " . $c['from'] . " → " . $c['to'];
                break;
        }

        $out[] = "";
    }

    return trim(implode("\n", $out));
}