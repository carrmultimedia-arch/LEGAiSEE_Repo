<?php

require_once __DIR__ . '/../kernel/kernel_boot.php';
require_once __DIR__ . '/../lib/legaisee_model.php';
require_once __DIR__ . '/../kernel/nav_engine.php';

kernel_validate_runtime();

/**
 * -----------------------------
 * INPUTS
 * -----------------------------
 */
$id_a = $_GET['a'] ?? null;
$id_b = $_GET['b'] ?? null;
$mode  = $_GET['mode'] ?? 'split'; // split | single

$back = kernel_nav_back();

if (!$id_a || !$id_b) {
    return "<h2>Two records required for comparison</h2>";
}

/**
 * -----------------------------
 * DATA FETCH (MODEL LAYER ONLY)
 * -----------------------------
 */
$page_a = legaisee_get_page($id_a);
$page_b = legaisee_get_page($id_b);

if (!$page_a || !$page_b) {
    return "<h2>One or both records not found</h2>";
}

/**
 * -----------------------------
 * INTELLIGENCE ENRICHMENT
 * -----------------------------
 */
$graph_a = legaisee_entity_graph($id_a);
$graph_b = legaisee_entity_graph($id_b);

ob_start();
?>

<div class="compare-view">

<!-- =========================
     TOP CONTROL BAR
========================= -->
<div class="compare-controls">

    <?php if ($back): ?>
        <a class="compare-back" href="<?= htmlspecialchars($back) ?>">← Back</a>
    <?php endif; ?>

    <div class="compare-toggle">
        <a href="?a=<?= $id_a ?>&b=<?= $id_b ?>&mode=single"
           class="<?= $mode === 'single' ? 'active' : '' ?>">
            Single View
        </a>

        <a href="?a=<?= $id_a ?>&b=<?= $id_b ?>&mode=split"
           class="<?= $mode === 'split' ? 'active' : '' ?>">
            2-Up Compare
        </a>
    </div>

</div>

<!-- =========================
     SINGLE VIEW MODE
========================= -->
<?php if ($mode === 'single'): ?>

    <div class="compare-single">

        <div class="compare-card">
            <h2><?= htmlspecialchars($page_a['title'] ?? 'Untitled') ?></h2>
            <pre><?= htmlspecialchars($page_a['content'] ?? '') ?></pre>
        </div>

        <div class="compare-card">
            <h2><?= htmlspecialchars($page_b['title'] ?? 'Untitled') ?></h2>
            <pre><?= htmlspecialchars($page_b['content'] ?? '') ?></pre>
        </div>

    </div>

<?php else: ?>

<!-- =========================
     SPLIT VIEW MODE (2-UP)
========================= -->

<div class="compare-split">

    <!-- LEFT -->
    <div class="compare-pane">

        <div class="compare-header">
            <h3><?= htmlspecialchars($page_a['title'] ?? 'Untitled') ?></h3>
        </div>

        <div class="compare-meta">
            AI Score: <?= htmlspecialchars($graph_a['score'] ?? 0) ?>
        </div>

        <pre class="compare-content">
<?= htmlspecialchars($page_a['content'] ?? '') ?>
        </pre>

    </div>

    <!-- RIGHT -->
    <div class="compare-pane">

        <div class="compare-header">
            <h3><?= htmlspecialchars($page_b['title'] ?? 'Untitled') ?></h3>
        </div>

        <div class="compare-meta">
            AI Score: <?= htmlspecialchars($graph_b['score'] ?? 0) ?>
        </div>

        <pre class="compare-content">
<?= htmlspecialchars($page_b['content'] ?? '') ?>
        </pre>

    </div>

</div>

<?php endif; ?>

</div>

<?php
return ob_get_clean();