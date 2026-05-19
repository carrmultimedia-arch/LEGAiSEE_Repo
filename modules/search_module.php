<?php
/**
 * search_module.php
 * LEGAiSEE — System Search + Dual Compare
 *
 * Pattern: HTML fragment — no DOCTYPE, no head, no body, no style tags
 * Styles:  ui/global.css (MODULE: search block)
 * Content loading: JS fetches api/search_load.php directly (bypasses shell)
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

require_once 'utils/bootstrap.php';

$db    = kernel_db();
$query = trim($_GET['q'] ?? '');

// ── System-wide search ────────────────────────────────────────────────────────

$results = [];

if ($query !== '') {

    // JSON sources
    $json_sources = [
        'cases'     => defined('CASES_ROOT')   ? CASES_ROOT   : DATA_ROOT . 'cases/',
        'clients'   => defined('CLIENTS_ROOT') ? CLIENTS_ROOT : DATA_ROOT . 'clients/',
        'prospects' => DATA_ROOT . 'prospects/',
        'network'   => DATA_ROOT . 'network/',
    ];

    foreach ($json_sources as $type => $dir) {
        if (!is_dir($dir)) continue;
        foreach (scandir($dir) as $file) {
            if ($file[0] === '.') continue;
            $full = $dir . $file;
            if (!is_file($full)) continue;
            $content = file_get_contents($full);
            if (stripos($file, $query) !== false || stripos($content, $query) !== false) {
                $decoded = json_decode($content, true);
                $label   = is_array($decoded)
                    ? ($decoded['name'] ?? $decoded['title'] ?? $decoded['business_name'] ?? $decoded['prospect_name'] ?? $file)
                    : $file;
                $pos     = stripos($content, $query);
                $snippet = $pos !== false
                    ? '…' . substr(strip_tags($content), max(0, $pos - 50), 140) . '…'
                    : '';
                $results[] = [
                    'ref'     => "json:{$type}:{$file}",
                    'label'   => $label,
                    'badge'   => strtoupper($type),
                    'source'  => "JSON / {$type}",
                    'snippet' => $snippet,
                ];
            }
        }
    }

    // MySQL: documents
    try {
        $stmt = $db->prepare("SELECT id, title, source FROM documents
            WHERE title LIKE :q OR source LIKE :q OR content LIKE :q LIMIT 20");
        $stmt->execute([':q' => "%{$query}%"]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $results[] = [
                'ref'     => "mysql:documents:{$r['id']}",
                'label'   => $r['title'] ?: "Document #{$r['id']}",
                'badge'   => 'DOC',
                'source'  => 'MySQL / documents',
                'snippet' => $r['source'] ?: '',
            ];
        }
    } catch (Exception $e) {}

    // MySQL: files
    try {
        $stmt = $db->prepare("SELECT id, filename, filetype FROM files WHERE filename LIKE :q LIMIT 20");
        $stmt->execute([':q' => "%{$query}%"]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $results[] = [
                'ref'     => "mysql:files:{$r['id']}",
                'label'   => $r['filename'],
                'badge'   => strtoupper($r['filetype'] ?: 'FILE'),
                'source'  => 'MySQL / files',
                'snippet' => '',
            ];
        }
    } catch (Exception $e) {}

    // MySQL: entities
    try {
        $stmt = $db->prepare("SELECT id, name, type, confidence FROM entities WHERE name LIKE :q LIMIT 20");
        $stmt->execute([':q' => "%{$query}%"]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $results[] = [
                'ref'     => "mysql:entities:{$r['id']}",
                'label'   => $r['name'],
                'badge'   => $r['type'] ?: 'ENTITY',
                'source'  => 'MySQL / entities',
                'snippet' => 'Confidence: ' . round($r['confidence'] * 100) . '%',
            ];
        }
    } catch (Exception $e) {}

    // MySQL: relationships
    try {
        $stmt = $db->prepare("
            SELECT r.id, r.type, r.confidence, e1.name AS a, e2.name AS b
            FROM relationships r
            LEFT JOIN entities e1 ON e1.id = r.entity_a_id
            LEFT JOIN entities e2 ON e2.id = r.entity_b_id
            WHERE e1.name LIKE :q OR e2.name LIKE :q OR r.type LIKE :q LIMIT 20");
        $stmt->execute([':q' => "%{$query}%"]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $results[] = [
                'ref'     => "mysql:relationships:{$r['id']}",
                'label'   => "{$r['a']} → {$r['type']} → {$r['b']}",
                'badge'   => 'REL',
                'source'  => 'MySQL / relationships',
                'snippet' => 'Confidence: ' . round($r['confidence'] * 100) . '%',
            ];
        }
    } catch (Exception $e) {}

    // MySQL: memory_ingest
    try {
        $stmt = $db->prepare("SELECT id, session_label, project_tag, platform, word_count
            FROM memory_ingest
            WHERE session_label LIKE :q OR project_tag LIKE :q OR raw_text LIKE :q LIMIT 10");
        $stmt->execute([':q' => "%{$query}%"]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $results[] = [
                'ref'     => "mysql:memory_ingest:{$r['id']}",
                'label'   => $r['session_label'] ?: "Session #{$r['id']}",
                'badge'   => 'SESSION',
                'source'  => 'MySQL / memory',
                'snippet' => "{$r['platform']} · {$r['project_tag']} · " . number_format((int)$r['word_count']) . ' words',
            ];
        }
    } catch (Exception $e) {}
}

ob_start();
?>
<div class="srch3-wrap">

    <!-- ══ COL 1: Search ═══════════════════════════════════════════════ -->
    <div class="srch3-col-search">

        <div class="srch3-controls">
            <input  class="srch3-query-input"
                    id="srch3-query"
                    type="text"
                    placeholder="Search entire system…"
                    value="<?= htmlspecialchars($query) ?>"
                    onkeydown="if(event.key==='Enter')leeSearch()">
            <button class="srch3-btn-execute" onclick="leeSearch()">Execute</button>
            <div class="srch3-ab-row">
                <button class="srch3-btn-set srch3-btn-seta" onclick="leeSetPane('a')">Set A</button>
                <button class="srch3-btn-set srch3-btn-setb" onclick="leeSetPane('b')">Set B</button>
            </div>
        </div>

        <?php if ($query !== '' && empty($results)): ?>
            <p class="srch3-empty">No results for "<em><?= htmlspecialchars($query) ?></em>"</p>
        <?php elseif (!empty($results)): ?>
            <div class="srch3-result-count"><?= count($results) ?> result<?= count($results) !== 1 ? 's' : '' ?></div>
        <?php endif; ?>

        <div class="srch3-list" id="srch3-list">
            <?php foreach ($results as $r): ?>
                <div class="srch3-item"
                     data-ref="<?= htmlspecialchars($r['ref']) ?>"
                     onclick="leeSelect(this)">
                    <div class="srch3-item-row">
                        <span class="srch3-badge"><?= htmlspecialchars($r['badge']) ?></span>
                        <span class="srch3-item-label"><?= htmlspecialchars($r['label']) ?></span>
                    </div>
                    <?php if ($r['snippet']): ?>
                        <div class="srch3-snippet"><?= htmlspecialchars($r['snippet']) ?></div>
                    <?php endif; ?>
                    <div class="srch3-item-src"><?= htmlspecialchars($r['source']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- ══ COL 2: Pane A ════════════════════════════════════════════════ -->
    <div class="srch3-col-pane">
        <div class="srch3-pane-head srch3-pane-head--a">
            <span class="srch3-pane-badge srch3-pane-badge--a">A</span>
            <span class="srch3-pane-title" id="srch3-title-a">Select a result → Set A</span>
            <button class="srch3-pane-clear" onclick="leeClearPane('a')">✕</button>
        </div>
        <div class="srch3-findbar">
            <input  class="srch3-find-input" id="srch3-find-a"
                    type="text" placeholder="Find in A…"
                    oninput="leeFindInPane('a')">
            <button class="srch3-find-nav" onclick="leeFindNav('a',-1)">↑</button>
            <button class="srch3-find-nav" onclick="leeFindNav('a', 1)">↓</button>
            <span   class="srch3-find-tally" id="srch3-tally-a"></span>
            <button class="srch3-find-x" onclick="leeClearFind('a')">✕</button>
        </div>
        <div class="srch3-viewer" id="srch3-viewer-a"></div>
    </div>

    <!-- ══ COL 3: Pane B ════════════════════════════════════════════════ -->
    <div class="srch3-col-pane">
        <div class="srch3-pane-head srch3-pane-head--b">
            <span class="srch3-pane-badge srch3-pane-badge--b">B</span>
            <span class="srch3-pane-title" id="srch3-title-b">Select a result → Set B</span>
            <button class="srch3-pane-clear" onclick="leeClearPane('b')">✕</button>
        </div>
        <div class="srch3-findbar">
            <input  class="srch3-find-input" id="srch3-find-b"
                    type="text" placeholder="Find in B…"
                    oninput="leeFindInPane('b')">
            <button class="srch3-find-nav" onclick="leeFindNav('b',-1)">↑</button>
            <button class="srch3-find-nav" onclick="leeFindNav('b', 1)">↓</button>
            <span   class="srch3-find-tally" id="srch3-tally-b"></span>
            <button class="srch3-find-x" onclick="leeClearFind('b')">✕</button>
        </div>
        <div class="srch3-viewer" id="srch3-viewer-b"></div>
    </div>

</div>

<script>
(function () {
    'use strict';

    // ── This URL goes directly to api/search_load.php, NOT through shell.php
    // That is critical — shell.php wraps modules in a buffer that blocks JSON responses
    var LOAD_URL = '/commandcenter/api/search_load.php?ref=';

    var selRef = null;
    var selEl  = null;

    var P = {
        a: { raw: '', marks: [], idx: 0 },
        b: { raw: '', marks: [], idx: 0 }
    };

    // ── Select a result in column 1 ───────────────────────────────────────────
    window.leeSelect = function (el) {
        if (selEl) selEl.classList.remove('srch3-item--sel');
        selEl  = el;
        selRef = el.dataset.ref;
        el.classList.add('srch3-item--sel');
    };

    // ── Set A or Set B — load selected result into a pane ─────────────────────
    window.leeSetPane = function (w) {
        if (!selRef) {
            alert('Click a result in the list first, then click Set ' + w.toUpperCase() + '.');
            return;
        }

        var viewer = document.getElementById('srch3-viewer-' + w);
        var title  = document.getElementById('srch3-title-'  + w);

        viewer.textContent = 'Loading…';
        title.textContent  = '…';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', LOAD_URL + encodeURIComponent(selRef), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) return;
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    P[w].raw   = data.text  || '(empty)';
                    P[w].marks = [];
                    P[w].idx   = 0;
                    title.textContent = data.label || selRef;
                    document.getElementById('srch3-find-'  + w).value       = '';
                    document.getElementById('srch3-tally-' + w).textContent = '';
                    renderPane(w);
                } catch (e) {
                    viewer.textContent = 'Error parsing response: ' + xhr.responseText.substring(0, 200);
                    title.textContent  = 'Error';
                }
            } else {
                viewer.textContent = 'Load failed (HTTP ' + xhr.status + '). Check that api/search_load.php exists on the server.';
                title.textContent  = 'Error';
            }
        };
        xhr.send();
    };

    // ── Render pane content (plain text or with find highlights) ──────────────
    function renderPane(w) {
        var viewer = document.getElementById('srch3-viewer-' + w);
        var term   = document.getElementById('srch3-find-' + w).value.trim();
        var raw    = P[w].raw;

        if (!term) {
            viewer.textContent = raw;
            P[w].marks = [];
            document.getElementById('srch3-tally-' + w).textContent = '';
            return;
        }

        var marks  = [];
        var html   = '';
        var last   = 0;
        var rx     = new RegExp(escRx(term), 'gi');
        var m;

        while ((m = rx.exec(raw)) !== null) {
            html += esc(raw.slice(last, m.index));
            html += '<mark class="srch3-mark srch3-mark--' + w + '" id="srch3-m-' + w + '-' + marks.length + '">'
                  + esc(m[0]) + '</mark>';
            marks.push(m.index);
            last = m.index + m[0].length;
        }
        html += esc(raw.slice(last));

        viewer.innerHTML = html;
        P[w].marks = marks;
        if (P[w].idx >= marks.length) P[w].idx = 0;
        updateTally(w);
        scrollToMark(w);
    }

    // ── Find in pane (triggered by typing in the find bar) ────────────────────
    window.leeFindInPane = function (w) {
        P[w].idx = 0;
        renderPane(w);
    };

    // ── Navigate prev/next match ──────────────────────────────────────────────
    window.leeFindNav = function (w, dir) {
        var n = P[w].marks.length;
        if (!n) return;
        P[w].idx = (P[w].idx + dir + n) % n;
        updateTally(w);
        scrollToMark(w);
    };

    function updateTally(w) {
        var n = P[w].marks.length;
        document.getElementById('srch3-tally-' + w).textContent =
            n ? (P[w].idx + 1) + '/' + n : '0';
    }

    function scrollToMark(w) {
        var el = document.getElementById('srch3-m-' + w + '-' + P[w].idx);
        if (el) el.scrollIntoView({ block: 'center', behavior: 'smooth' });
    }

    // ── Clear pane ────────────────────────────────────────────────────────────
    window.leeClearPane = function (w) {
        P[w].raw   = '';
        P[w].marks = [];
        P[w].idx   = 0;
        document.getElementById('srch3-viewer-' + w).textContent    = '';
        document.getElementById('srch3-title-'  + w).textContent    = 'Select a result → Set ' + w.toUpperCase();
        document.getElementById('srch3-find-'   + w).value          = '';
        document.getElementById('srch3-tally-'  + w).textContent    = '';
    };

    // ── Clear find bar ────────────────────────────────────────────────────────
    window.leeClearFind = function (w) {
        document.getElementById('srch3-find-' + w).value = '';
        P[w].idx = 0;
        renderPane(w);
    };

    // ── Search form submit ────────────────────────────────────────────────────
    window.leeSearch = function () {
        var q = document.getElementById('srch3-query').value.trim();
        window.location.href = '?module=search&q=' + encodeURIComponent(q);
    };

    // ── Helpers ───────────────────────────────────────────────────────────────
    function esc(s) {
        return s
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
    function escRx(s) {
        return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

})();
</script>
<?php
return ob_get_clean();