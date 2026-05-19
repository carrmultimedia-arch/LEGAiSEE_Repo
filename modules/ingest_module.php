<?php
/**
 * ingest_module.php
 * LEGAiSEE — Ingest & AI Memory Module
 *
 * Migration of commandcenter/ingest.php to proper module pattern.
 * Pattern: HTML fragment only — no DOCTYPE, no head, no body, no style tags
 * Styles:  ui/global.css (MODULE: ingest block)
 * Loaded:  shell.php?module=ingest
 * DB:      kernel_db() only
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

$db = kernel_db();

// ── Handle form submissions ───────────────────────────────────────────────────

$flash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['ingest_action'] ?? '';

    if ($action === 'paste_transcript') {
        $raw_text      = trim($_POST['raw_text']      ?? '');
        $session_label = trim($_POST['session_label'] ?? '');
        $project_tag   = trim($_POST['project_tag']   ?? 'untagged');
        $platform      = trim($_POST['platform']      ?? 'unknown');
        $domain_id     = intval($_POST['domain_id']   ?? 0) ?: null;
        $project_id    = intval($_POST['project_id']  ?? 0) ?: null;

        if (strlen($raw_text) < 20) {
            $flash = ['type' => 'error', 'msg' => 'Transcript is too short — paste the full session text.'];
        } else {
            try {
                $word_count = str_word_count($raw_text);
                $stmt = $db->prepare("
                    INSERT INTO memory_ingest
                        (session_label, project_tag, platform, domain_id, project_id,
                         raw_text, word_count, context, created_at)
                    VALUES
                        (:label, :tag, :platform, :domain_id, :project_id,
                         :raw_text, :word_count, 'memory', NOW())
                ");
                $stmt->execute([
                    ':label'      => $session_label,
                    ':tag'        => $project_tag,
                    ':platform'   => $platform,
                    ':domain_id'  => $domain_id,
                    ':project_id' => $project_id,
                    ':raw_text'   => $raw_text,
                    ':word_count' => $word_count,
                ]);
                $flash = ['type' => 'ok', 'msg' => "Stored {$word_count} words as session #{$db->lastInsertId()}."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'DB error: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'upload_file') {
        if (!empty($_FILES['upload_file']['tmp_name']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
            $orig_name  = basename($_FILES['upload_file']['name']);
            $safe_name  = preg_replace('/[^a-zA-Z0-9._-]/', '_', $orig_name);
            $target_dir = DATA_ROOT . 'files/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
            $target = $target_dir . time() . '_' . $safe_name;
            if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $target)) {
                try {
                    $stmt = $db->prepare("INSERT INTO files (filename, filepath, filetype, filesize, context, created_at)
                        VALUES (:fn, :fp, :ft, :fs, 'legaisee', NOW())");
                    $stmt->execute([':fn' => $safe_name, ':fp' => $target,
                        ':ft' => strtolower(pathinfo($safe_name, PATHINFO_EXTENSION)), ':fs' => filesize($target)]);
                } catch (Exception $e) {}
                $flash = ['type' => 'ok', 'msg' => "'{$safe_name}' uploaded successfully."];
            } else {
                $flash = ['type' => 'error', 'msg' => 'Upload failed — check permissions on data/files/'];
            }
        } else {
            $flash = ['type' => 'error', 'msg' => 'No file received or upload error.'];
        }
    }

    if ($action === 'delete_session') {
        $del_id = intval($_POST['session_id'] ?? 0);
        if ($del_id > 0) {
            try {
                $db->exec("DELETE FROM memory_ingest WHERE id = {$del_id}");
                $flash = ['type' => 'ok', 'msg' => "Session #{$del_id} deleted."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Delete failed: ' . $e->getMessage()];
            }
        }
    }
}

// ── Stats ─────────────────────────────────────────────────────────────────────

$stat_sessions = 0; $stat_words = 0; $stat_files = 0; $stat_docs = 0;
try { $stat_sessions = $db->query("SELECT COUNT(*) FROM memory_ingest")->fetchColumn(); } catch (Exception $e) {}
try { $stat_words    = $db->query("SELECT COALESCE(SUM(word_count),0) FROM memory_ingest")->fetchColumn(); } catch (Exception $e) {}
try { $stat_files    = $db->query("SELECT COUNT(*) FROM files")->fetchColumn(); } catch (Exception $e) {}
try { $stat_docs     = $db->query("SELECT COUNT(*) FROM documents")->fetchColumn(); } catch (Exception $e) {}

// ── Dropdowns ─────────────────────────────────────────────────────────────────

$projects = []; $domains = [];
try { $projects = $db->query("SELECT id, name FROM projects ORDER BY name")->fetchAll(PDO::FETCH_ASSOC); } catch (Exception $e) {}
try { $domains  = $db->query("SELECT id, name FROM memory_domains ORDER BY name")->fetchAll(PDO::FETCH_ASSOC); } catch (Exception $e) {}

// ── Recent sessions ───────────────────────────────────────────────────────────

$sessions = [];
try {
    $sessions = $db->query("SELECT id, session_label, project_tag, platform, word_count, created_at
        FROM memory_ingest ORDER BY created_at DESC LIMIT 30")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$active_tab = $_GET['tab'] ?? 'paste';
if (!in_array($active_tab, ['paste', 'upload', 'sessions'])) $active_tab = 'paste';

ob_start();
?>
<div class="ingest-wrap">

    <?php if ($flash): ?>
        <div class="ingest-flash ingest-flash--<?= $flash['type'] ?>">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
    <?php endif; ?>

    <div class="ingest-stats">
        <div class="ingest-stat">
            <span class="ingest-stat__n"><?= number_format($stat_sessions) ?></span>
            <span class="ingest-stat__l">AI Sessions</span>
        </div>
        <div class="ingest-stat">
            <span class="ingest-stat__n"><?= number_format($stat_words) ?></span>
            <span class="ingest-stat__l">Words Stored</span>
        </div>
        <div class="ingest-stat">
            <span class="ingest-stat__n"><?= number_format($stat_files) ?></span>
            <span class="ingest-stat__l">Files</span>
        </div>
        <div class="ingest-stat">
            <span class="ingest-stat__n"><?= number_format($stat_docs) ?></span>
            <span class="ingest-stat__l">Documents</span>
        </div>
    </div>

    <div class="ingest-tabs">
        <a class="ingest-tab <?= $active_tab === 'paste'    ? 'ingest-tab--active' : '' ?>" href="?module=ingest&tab=paste">Paste AI Chat</a>
        <a class="ingest-tab <?= $active_tab === 'upload'   ? 'ingest-tab--active' : '' ?>" href="?module=ingest&tab=upload">Upload File</a>
        <a class="ingest-tab <?= $active_tab === 'sessions' ? 'ingest-tab--active' : '' ?>" href="?module=ingest&tab=sessions">Sessions (<?= number_format($stat_sessions) ?>)</a>
    </div>

    <?php if ($active_tab === 'paste'): ?>
    <form class="ingest-form" method="POST">
        <input type="hidden" name="ingest_action" value="paste_transcript">
        <div class="ingest-row">
            <label class="ingest-label">Session Label</label>
            <input class="ingest-input" type="text" name="session_label" placeholder="e.g. Shell.php rebuild — May 13">
        </div>
        <div class="ingest-row ingest-row--split">
            <div>
                <label class="ingest-label">Platform</label>
                <select class="ingest-select" name="platform">
                    <option value="claude">Claude (Anthropic)</option>
                    <option value="gemini">Gemini</option>
                    <option value="chatgpt">ChatGPT</option>
                    <option value="perplexity">Perplexity</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="ingest-label">Project Tag</label>
                <input class="ingest-input" type="text" name="project_tag" value="commandcenter_build">
            </div>
        </div>
        <div class="ingest-row ingest-row--split">
            <div>
                <label class="ingest-label">Project</label>
                <select class="ingest-select" name="project_id">
                    <option value="">— Select —</option>
                    <?php foreach ($projects as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="ingest-label">Domain</label>
                <select class="ingest-select" name="domain_id">
                    <option value="">— Select —</option>
                    <?php foreach ($domains as $d): ?>
                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="ingest-row">
            <label class="ingest-label">Full AI Session Transcript</label>
            <textarea class="ingest-textarea" name="raw_text"
                placeholder="Paste the complete AI chat session here — all prompts and all responses. The system stores, tags, and makes it searchable."></textarea>
        </div>
        <button class="ingest-submit" type="submit">Store Session</button>
    </form>
    <?php endif; ?>

    <?php if ($active_tab === 'upload'): ?>
    <form class="ingest-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ingest_action" value="upload_file">
        <div class="ingest-row">
            <label class="ingest-label">Select File to Upload</label>
            <p class="ingest-hint">PDF, DOCX, TXT, JSON, images, and most other formats.
               Stored in <code>data/files/</code> and registered in the files table.</p>
            <input class="ingest-file-input" type="file" name="upload_file">
        </div>
        <button class="ingest-submit" type="submit">Upload</button>
    </form>
    <?php endif; ?>

    <?php if ($active_tab === 'sessions'): ?>
        <?php if (empty($sessions)): ?>
            <p class="ingest-empty">No sessions stored yet.</p>
        <?php else: ?>
        <table class="ingest-table">
            <thead>
                <tr><th>#</th><th>Label</th><th>Project Tag</th><th>Platform</th><th>Words</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['session_label'] ?: '—') ?></td>
                    <td><?= htmlspecialchars($s['project_tag']   ?: '—') ?></td>
                    <td><?= htmlspecialchars($s['platform']      ?: '—') ?></td>
                    <td><?= number_format((int)$s['word_count']) ?></td>
                    <td><?= substr($s['created_at'], 0, 10) ?></td>
                    <td>
                        <form method="POST" style="display:inline"
                              onsubmit="return confirm('Delete session #<?= $s['id'] ?>?')">
                            <input type="hidden" name="ingest_action" value="delete_session">
                            <input type="hidden" name="session_id"    value="<?= $s['id'] ?>">
                            <button class="ingest-del-btn" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    <?php endif; ?>

</div>
<?php
return ob_get_clean();