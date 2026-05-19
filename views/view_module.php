<?php

require_once __DIR__ . '/../lib/legaisee_model.php';
require_once __DIR__ . '/../kernel/nav_engine.php';

kernel_validate_runtime();

$id = $_GET['id'] ?? null;

$back = kernel_nav_back();

if (!$id) {
    return "<h2>No record selected</h2>";
}

/**
 * -----------------------------
 * UNIFIED DATA FETCH (MODEL LAYER)
 * -----------------------------
 */
$page = legaisee_get_page($id);

if (!$page) {
    return "<h2>Record not found</h2>";
}

/**
 * -----------------------------
 * INTELLIGENCE ENRICHMENT
 * -----------------------------
 */
$graph = legaisee_entity_graph($id);
$relations = $graph['relations'] ?? [];
$reverse   = $graph['reverse'] ?? [];
$tags      = $graph['tags'] ?? [];
$score     = $graph['score'] ?? 0;

ob_start();
?>

<div class="view-module">

<?php if ($back): ?>
    <div class="view-back">
        <a href="<?= htmlspecialchars($back) ?>">← Back</a>
    </div>
<?php endif; ?>

<!-- =========================
     HEADER / TITLE BLOCK
========================= -->
<div class="view-header">
    <h2><?= htmlspecialchars($page['title'] ?? 'Untitled') ?></h2>

    <?php if ($score): ?>
        <div class="ai-score">
            AI Score: <?= htmlspecialchars($score) ?>
        </div>
    <?php endif; ?>
</div>

<!-- =========================
     TAGS (AI LAYER)
========================= -->
<?php if (!empty($tags)): ?>
    <div class="view-tags">
        <?php foreach (explode(',', $tags) as $tag): ?>
            <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- =========================
     CONTENT BLOCK (CORE)
========================= -->
<div class="view-content-card">
    <pre class="view-content-text">
<?= htmlspecialchars($page['content'] ?? '') ?>
    </pre>
</div>

<!-- =========================
     RELATION INTELLIGENCE
========================= -->
<div class="view-relations">

    <h3>Linked Intelligence</h3>

    <?php if (!empty($relations)): ?>
        <ul>
            <?php foreach ($relations as $r): ?>
                <li>
                    Target ID: <?= htmlspecialchars($r['target_id']) ?>
                    (weight: <?= htmlspecialchars($r['weight']) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No outgoing relations.</p>
    <?php endif; ?>

    <h3>Reverse Connections</h3>

    <?php if (!empty($reverse)): ?>
        <ul>
            <?php foreach ($reverse as $r): ?>
                <li>
                    Source ID: <?= htmlspecialchars($r['source_id']) ?>
                    (strength: <?= htmlspecialchars($r['strength']) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No incoming relations.</p>
    <?php endif; ?>

</div>

</div>

<?php
return ob_get_clean();