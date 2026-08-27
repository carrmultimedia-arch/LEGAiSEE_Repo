<?php
/**
 * dig_review_module.php
 * LEGAiSEE — Dig Review Interface
 *
 * The human-in-the-loop verification layer.
 * John marks each extracted finding: confirmed / rejected / needs-more-info
 * Only confirmed findings flow into reports.
 *
 * Pattern: HTML fragment only — no DOCTYPE/head/body
 * Loaded by: shell.php via renderModule('dig_review')
 * DB: kernel_db() only
 *
 * REQUIRED: Run the dig_review table migration before using this module.
 * See the CREATE TABLE block at the bottom of this file.
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

require_once __DIR__ . '/../kernel/db.php';
$db = kernel_db();

// ── Ensure review_flags table exists ─────────────────────────────────────────
// (idempotent — safe to call every load)
try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS review_flags (
            id           INT PRIMARY KEY AUTO_INCREMENT,
            source_table TEXT NOT NULL,
            source_id    INTEGER NOT NULL,
            context      TEXT DEFAULT NULL,
            status       TEXT NOT NULL DEFAULT 'pending',
            operator_note TEXT DEFAULT NULL,
            reviewed_at  DATETIME NULL,
            created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (Exception $e) { /* table likely already exists */ }

// ── Handle status update (AJAX-friendly POST) ─────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_action'])) {
    header('Content-Type: application/json');

    $action   = $_POST['review_action'];
    $flag_id  = intval($_POST['flag_id'] ?? 0);
    $status   = $_POST['status'] ?? '';
    $note     = trim($_POST['note'] ?? '');

    $allowed_statuses = ['confirmed', 'rejected', 'needs_more_info', 'pending'];

    if ($action === 'update_status' && $flag_id && in_array($status, $allowed_statuses)) {
        try {
            $stmt = $db->prepare("
                UPDATE review_flags
                SET status = :status,
                    operator_note = :note,
                    reviewed_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ");
            $stmt->execute([':status' => $status, ':note' => $note, ':id' => $flag_id]);
            echo json_encode(['ok' => true]);
        } catch (Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    // Auto-queue: pull unreviewed entities/relationships into review_flags
    if ($action === 'queue_unreviewed') {
        $queued = 0;
        try {
            // Queue entities not yet in review_flags
            $new_entities = $db->query("
                SELECT e.id FROM entities e
                LEFT JOIN review_flags rf ON rf.source_table = 'entities' AND rf.source_id = e.id
                WHERE rf.id IS NULL
            ")->fetchAll(PDO::FETCH_COLUMN);

            $stmt = $db->prepare("
                INSERT INTO review_flags (source_table, source_id, context, status)
                VALUES ('entities', :sid, (SELECT context FROM entities WHERE id = :sid2), 'pending')
            ");
            foreach ($new_entities as $eid) {
                $stmt->execute([':sid' => $eid, ':sid2' => $eid]);
                $queued++;
            }

            // Queue relationships
            $new_rels = $db->query("
                SELECT r.id FROM relationships r
                LEFT JOIN review_flags rf ON rf.source_table = 'relationships' AND rf.source_id = r.id
                WHERE rf.id IS NULL
            ")->fetchAll(PDO::FETCH_COLUMN);

            $stmt = $db->prepare("
                INSERT INTO review_flags (source_table, source_id, context, status)
                VALUES ('relationships', :sid, (SELECT context FROM relationships WHERE id = :sid2), 'pending')
            ");
            foreach ($new_rels as $rid) {
                $stmt->execute([':sid' => $rid, ':sid2' => $rid]);
                $queued++;
            }

            echo json_encode(['ok' => true, 'queued' => $queued]);
        } catch (Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Unknown action']);
    exit;
}

// ── Load WO-D findings from case analysis files ─────────────────────────────

$clientsDir = __DIR__ . '/../data/clients';
$caseFindings = [];

if (is_dir($clientsDir)) {
    foreach (glob($clientsDir . '/*/cases/*/meta.json') as $metaFile) {
        $caseDir = dirname($metaFile);
        $caseId = basename($caseDir);
        $clientId = basename(dirname(dirname($caseDir)));
        
        $meta = json_decode(file_get_contents($metaFile), true);
        if ($meta) {
            // Load insights.json
            $insightsFile = $caseDir . '/insights.json';
            if (file_exists($insightsFile)) {
                $insights = json_decode(file_get_contents($insightsFile), true);
                if ($insights) {
                    foreach ($insights as $insight) {
                        $caseFindings[] = [
                            'source_table' => 'insight',
                            'source_id' => $caseId,
                            'context' => $clientId,
                            'status' => 'pending',
                            'label' => $insight['summary'] ?? 'Unknown insight',
                            'detail' => "Type: {$insight['type']}, Confidence: {$insight['confidence']}",
                            'type_display' => 'Insight'
                        ];
                    }
                }
            }
            
            // Load clusters.json
            $clustersFile = $caseDir . '/clusters.json';
            if (file_exists($clustersFile)) {
                $clusters = json_decode(file_get_contents($clustersFile), true);
                if ($clusters) {
                    foreach ($clusters as $clusterName => $members) {
                        $caseFindings[] = [
                            'source_table' => 'cluster',
                            'source_id' => $caseId,
                            'context' => $clientId,
                            'status' => 'pending',
                            'label' => $clusterName,
                            'detail' => count($members) . ' members',
                            'type_display' => 'Cluster'
                        ];
                    }
                }
            }
            
            // Load network.json
            $networkFile = $caseDir . '/network.json';
            if (file_exists($networkFile)) {
                $network = json_decode(file_get_contents($networkFile), true);
                if ($network && isset($network['nodes'])) {
                    foreach ($network['nodes'] as $node) {
                        $caseFindings[] = [
                            'source_table' => 'network_node',
                            'source_id' => $node['id'],
                            'context' => $clientId,
                            'status' => 'pending',
                            'label' => $node['content'] ?? $node['id'],
                            'detail' => "Type: {$node['type']}, Strength: {$node['strength']}",
                            'type_display' => 'Network Node'
                        ];
                    }
                }
            }
        }
    }
}

// ── Load review queue from database ───────────────────────────────────────────

$filter_status  = $_GET['status_filter'] ?? 'pending';
$filter_context = $_GET['context_filter'] ?? '';

$allowed_statuses = ['pending', 'confirmed', 'rejected', 'needs_more_info', 'all'];
if (!in_array($filter_status, $allowed_statuses)) $filter_status = 'pending';

$where_clauses = [];
$params        = [];

if ($filter_status !== 'all') {
    $where_clauses[] = 'rf.status = :status';
    $params[':status'] = $filter_status;
}
if ($filter_context) {
    $where_clauses[] = 'rf.context = :context';
    $params[':context'] = $filter_context;
}

$where_sql = $where_clauses ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

$flags = [];
try {
    $stmt = $db->prepare("
        SELECT rf.id, rf.source_table, rf.source_id, rf.status, rf.operator_note,
               rf.context, rf.reviewed_at, rf.created_at
        FROM review_flags rf
        {$where_sql}
        ORDER BY rf.created_at DESC
        LIMIT 100
    ");
    $stmt->execute($params);
    $flags = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Merge case findings with database flags
$mergedFlags = array_merge($caseFindings, $flags);

// ── Hydrate flags with source data ───────────────────────────────────────────

foreach ($mergedFlags as &$flag) {
    if (!isset($flag['label'])) {
        $flag['label']   = '—';
        $flag['detail']  = '';
        $flag['type_display'] = ucfirst(str_replace('_', ' ', $flag['source_table']));
    }

    try {
        if ($flag['source_table'] === 'entities') {
            $row = $db->query("SELECT canonical_name, entity_type, confidence FROM entities WHERE id = {$flag['source_id']}")->fetch();
            if ($row) {
                $flag['label']  = $row['canonical_name'];
                $flag['detail'] = "Type: {$row['entity_type']}  |  Confidence: " . round($row['confidence'] * 100) . '%';
            }
        } elseif ($flag['source_table'] === 'relationships') {
            $row = $db->query("
                SELECT r.relation_type, r.strength,
                       e1.canonical_name AS entity_a, e2.canonical_name AS entity_b
                FROM relationships r
                LEFT JOIN entities e1 ON e1.id = r.from_entity
                LEFT JOIN entities e2 ON e2.id = r.to_entity
                WHERE r.id = {$flag['source_id']}
            ")->fetch();
            if ($row) {
                $flag['label']  = "{$row['entity_a']} → {$row['relation_type']} → {$row['entity_b']}";
                $flag['detail'] = 'Strength: ' . round($row['strength'] * 100) . '%';
            }
        } elseif ($flag['source_table'] === 'documents') {
            $row = $db->query("SELECT title, source FROM documents WHERE id = {$flag['source_id']}")->fetch();
            if ($row) {
                $flag['label']  = $row['title'] ?: 'Untitled';
                $flag['detail'] = 'Source: ' . ($row['source'] ?: '—');
            }
        }
    } catch (Exception $e) {}
}
unset($flag);

// ── Counts for status bar ─────────────────────────────────────────────────────

$counts = ['pending' => 0, 'confirmed' => 0, 'rejected' => 0, 'needs_more_info' => 0];

// Count from merged flags (case patterns + database)
foreach ($mergedFlags as $f) {
    $status = $f['status'] ?? 'pending';
    if (isset($counts[$status])) {
        $counts[$status]++;
    }
}

// ── Render ────────────────────────────────────────────────────────────────────
ob_start();
?>
<div class="review-module">

    <!-- Header Bar -->
    <div class="review-header">
        <div class="review-counts">
            <a href="?module=dig_review&status_filter=pending"
               class="review-count <?= $filter_status === 'pending' ? 'review-count--active' : '' ?>">
                <span class="review-count__n"><?= $counts['pending'] ?></span>
                <span class="review-count__l">Pending</span>
            </a>
            <a href="?module=dig_review&status_filter=confirmed"
               class="review-count review-count--confirmed <?= $filter_status === 'confirmed' ? 'review-count--active' : '' ?>">
                <span class="review-count__n"><?= $counts['confirmed'] ?></span>
                <span class="review-count__l">Confirmed</span>
            </a>
            <a href="?module=dig_review&status_filter=needs_more_info"
               class="review-count review-count--needs <?= $filter_status === 'needs_more_info' ? 'review-count--active' : '' ?>">
                <span class="review-count__n"><?= $counts['needs_more_info'] ?></span>
                <span class="review-count__l">Needs Info</span>
            </a>
            <a href="?module=dig_review&status_filter=rejected"
               class="review-count review-count--rejected <?= $filter_status === 'rejected' ? 'review-count--active' : '' ?>">
                <span class="review-count__n"><?= $counts['rejected'] ?></span>
                <span class="review-count__l">Rejected</span>
            </a>
            <a href="?module=dig_review&status_filter=all"
               class="review-count <?= $filter_status === 'all' ? 'review-count--active' : '' ?>">
                <span class="review-count__n"><?= array_sum($counts) ?></span>
                <span class="review-count__l">All</span>
            </a>
        </div>
        <button class="review-queue-btn" onclick="leeQueueUnreviewed(this)">
            ↓ Queue New Findings
        </button>
    </div>

    <!-- Filter -->
    <div class="review-filter-row">
        <span class="review-filter-label">Context:</span>
        <a href="?module=dig_review&status_filter=<?= $filter_status ?>"
           class="review-filter-chip <?= !$filter_context ? 'review-filter-chip--active' : '' ?>">All</a>
        <a href="?module=dig_review&status_filter=<?= $filter_status ?>&context_filter=legaisee"
           class="review-filter-chip <?= $filter_context === 'legaisee' ? 'review-filter-chip--active' : '' ?>">LEGAiSEE</a>
        <a href="?module=dig_review&status_filter=<?= $filter_status ?>&context_filter=memory"
           class="review-filter-chip <?= $filter_context === 'memory' ? 'review-filter-chip--active' : '' ?>">Memory</a>
        <a href="?module=dig_review&status_filter=<?= $filter_status ?>&context_filter=general"
           class="review-filter-chip <?= $filter_context === 'general' ? 'review-filter-chip--active' : '' ?>">General</a>
    </div>

    <!-- Review Queue -->
    <?php if (empty($mergedFlags)): ?>
        <div class="review-empty">
            <?php if ($filter_status === 'pending'): ?>
                <p>Nothing in the review queue. Case patterns from WO-D analysis are loaded automatically.</p>
            <?php else: ?>
                <p>No items with status: <strong><?= htmlspecialchars($filter_status) ?></strong></p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="review-list" id="review-list">
            <?php foreach ($mergedFlags as $index => $flag): ?>
                <div class="review-card review-card--<?= $flag['status'] ?>" id="rfcard-<?= $flag['id'] ?? 'case_' . $index ?>">
                    <div class="review-card__meta">
                        <span class="review-card__type"><?= htmlspecialchars($flag['type_display']) ?></span>
                        <span class="review-card__context"><?= htmlspecialchars($flag['context'] ?: 'untagged') ?></span>
                        <span class="review-card__date"><?= htmlspecialchars(substr($flag['created_at'] ?? date('Y-m-d'), 0, 10)) ?></span>
                    </div>
                    <div class="review-card__label"><?= htmlspecialchars($flag['label']) ?></div>
                    <?php if ($flag['detail']): ?>
                        <div class="review-card__detail"><?= htmlspecialchars($flag['detail']) ?></div>
                    <?php endif; ?>

                    <?php if ($flag['operator_note']): ?>
                        <div class="review-card__note">📝 <?= htmlspecialchars($flag['operator_note']) ?></div>
                    <?php endif; ?>

                    <!-- Action buttons -->
                    <div class="review-card__actions">
                        <?php if (isset($flag['id'])): ?>
                            <button class="review-btn review-btn--confirm"
                                onclick="leeUpdateFlag(<?= $flag['id'] ?>, 'confirmed')">✓ Confirm</button>
                            <button class="review-btn review-btn--needs"
                                onclick="leeUpdateFlagWithNote(<?= $flag['id'] ?>, 'needs_more_info')">? Needs Info</button>
                            <button class="review-btn review-btn--reject"
                                onclick="leeUpdateFlag(<?= $flag['id'] ?>, 'rejected')">✗ Reject</button>
                            <?php if ($flag['status'] !== 'pending'): ?>
                                <button class="review-btn review-btn--reset"
                                    onclick="leeUpdateFlag(<?= $flag['id'] ?>, 'pending')">↺ Reset</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="review-card__note">Case pattern (auto-loaded)</span>
                        <?php endif; ?>
                    </div>

                    <!-- Status badge -->
                    <div class="review-card__status-badge review-badge--<?= $flag['status'] ?>">
                        <?= strtoupper(str_replace('_', ' ', $flag['status'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<style>
.review-module { padding: .5rem 0; }

/* Header */
.review-header  { display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 1rem; flex-wrap: wrap; gap: .8rem; }
.review-counts  { display: flex; gap: .5rem; flex-wrap: wrap; }
.review-count   { display: flex; flex-direction: column; align-items: center;
    padding: .4rem .8rem; border-radius: 7px; border: 1px solid rgba(244,225,133,.2);
    color: #CDAD69; text-decoration: none; min-width: 60px; }
.review-count:hover,
.review-count--active { background: rgba(244,225,133,.1); color: #F4E185; }
.review-count__n { font-size: 1.2rem; font-weight: 700; line-height: 1; }
.review-count__l { font-size: .65rem; text-transform: uppercase; letter-spacing: .04em; }
.review-count--confirmed { border-color: rgba(80,200,80,.3); color: #6dc96d; }
.review-count--needs     { border-color: rgba(200,160,40,.3); color: #c8a040; }
.review-count--rejected  { border-color: rgba(200,60,60,.3); color: #c07070; }

.review-queue-btn { background: #89612B; color: #F4E185; border: none;
    padding: .45rem 1rem; border-radius: 6px; cursor: pointer; font-size: .85rem; }
.review-queue-btn:hover { background: #CDAD69; color: #0a0a0c; }

/* Filter row */
.review-filter-row   { display: flex; align-items: center; gap: .4rem;
    margin-bottom: 1rem; flex-wrap: wrap; }
.review-filter-label { font-size: .75rem; color: #666; text-transform: uppercase; letter-spacing: .04em; }
.review-filter-chip  { font-size: .78rem; padding: .2rem .6rem; border-radius: 12px;
    border: 1px solid rgba(244,225,133,.2); color: #888; text-decoration: none; }
.review-filter-chip:hover,
.review-filter-chip--active { background: rgba(244,225,133,.1); color: #F4E185; border-color: rgba(244,225,133,.4); }

/* Cards */
.review-list { display: flex; flex-direction: column; gap: .6rem; }

.review-card { position: relative; background: rgba(10,10,12,.5);
    border: 1px solid rgba(244,225,133,.12); border-radius: 10px;
    padding: .9rem 1rem 1rem; transition: border-color .2s; }
.review-card:hover { border-color: rgba(244,225,133,.25); }
.review-card--confirmed { border-left: 3px solid #4a8a4a; }
.review-card--rejected  { border-left: 3px solid #7a3a3a; }
.review-card--needs_more_info { border-left: 3px solid #7a6020; }
.review-card--pending   { border-left: 3px solid rgba(244,225,133,.3); }

.review-card__meta   { display: flex; gap: .6rem; margin-bottom: .4rem; flex-wrap: wrap; }
.review-card__type   { font-size: .7rem; background: rgba(244,225,133,.1);
    color: #CDAD69; padding: .1rem .5rem; border-radius: 4px; text-transform: uppercase; }
.review-card__context { font-size: .7rem; color: #666; padding: .1rem .3rem; }
.review-card__date   { font-size: .7rem; color: #555; margin-left: auto; }

.review-card__label  { font-size: .95rem; color: #e8e0cc; font-weight: 500; margin-bottom: .2rem; }
.review-card__detail { font-size: .78rem; color: #888; margin-bottom: .5rem; }
.review-card__note   { font-size: .8rem; color: #b09050; background: rgba(137,97,43,.12);
    border-radius: 5px; padding: .3rem .6rem; margin-bottom: .5rem; }

.review-card__actions { display: flex; gap: .4rem; flex-wrap: wrap; margin-top: .6rem; }
.review-btn { border: none; padding: .3rem .7rem; border-radius: 5px;
    cursor: pointer; font-size: .8rem; font-weight: 600; transition: opacity .15s; }
.review-btn:hover { opacity: .8; }
.review-btn--confirm { background: #2d6a2d; color: #8fde8f; }
.review-btn--needs   { background: #5a4010; color: #c8a040; }
.review-btn--reject  { background: #6a2020; color: #e08080; }
.review-btn--reset   { background: rgba(244,225,133,.08); color: #888; }

.review-card__status-badge { position: absolute; top: .7rem; right: .8rem;
    font-size: .62rem; font-weight: 700; letter-spacing: .06em; padding: .15rem .45rem;
    border-radius: 4px; }
.review-badge--pending          { background: rgba(244,225,133,.1);  color: #888; }
.review-badge--confirmed        { background: rgba(80,200,80,.15);   color: #6dc96d; }
.review-badge--rejected         { background: rgba(200,60,60,.15);   color: #c07070; }
.review-badge--needs_more_info  { background: rgba(200,160,40,.15);  color: #c8a040; }

.review-empty { padding: 2rem; text-align: center; color: #666; font-style: italic; }
.review-empty p { margin: 0; }
.review-empty strong { color: #c8bfa8; }
</style>

<script>
function leeUpdateFlag(flagId, status, note) {
    note = note || '';
    const card = document.getElementById('rfcard-' + flagId);
    if (card) {
        const btns = card.querySelectorAll('.review-btn');
        btns.forEach(b => b.disabled = true);
    }

    fetch('?module=dig_review', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
            review_action: 'update_status',
            flag_id: flagId,
            status: status,
            note: note
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            if (card) {
                // Update badge
                const badge = card.querySelector('.review-card__status-badge');
                if (badge) {
                    badge.className = 'review-card__status-badge review-badge--' + status;
                    badge.textContent = status.replace(/_/g,' ').toUpperCase();
                }
                // Update card border class
                card.className = 'review-card review-card--' + status;
                // Re-enable buttons
                card.querySelectorAll('.review-btn').forEach(b => b.disabled = false);
                // Add reset button if not pending
                if (status !== 'pending') {
                    const actions = card.querySelector('.review-card__actions');
                    if (actions && !actions.querySelector('.review-btn--reset')) {
                        const btn = document.createElement('button');
                        btn.className = 'review-btn review-btn--reset';
                        btn.textContent = '↺ Reset';
                        btn.onclick = () => leeUpdateFlag(flagId, 'pending');
                        actions.appendChild(btn);
                    }
                }
                if (note) {
                    let noteEl = card.querySelector('.review-card__note');
                    if (!noteEl) {
                        noteEl = document.createElement('div');
                        noteEl.className = 'review-card__note';
                        card.querySelector('.review-card__actions').before(noteEl);
                    }
                    noteEl.textContent = '📝 ' + note;
                }
            }
        } else {
            alert('Error: ' + (data.error || 'Unknown'));
            if (card) card.querySelectorAll('.review-btn').forEach(b => b.disabled = false);
        }
    });
}

function leeUpdateFlagWithNote(flagId, status) {
    const note = prompt('Note for this finding (optional):');
    if (note === null) return; // Cancelled
    leeUpdateFlag(flagId, status, note);
}

function leeQueueUnreviewed(btn) {
    btn.disabled = true;
    btn.textContent = 'Queuing...';
    fetch('?module=dig_review', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({review_action: 'queue_unreviewed'})
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = '↓ Queue New Findings';
        if (data.ok) {
            if (data.queued > 0) {
                window.location.reload();
            } else {
                alert('All findings already in queue. Nothing new to add.');
            }
        } else {
            alert('Error: ' + (data.error || 'Unknown'));
        }
    });
}
</script>
<?php
return ob_get_clean();