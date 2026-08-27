<?php
/**
 * ingest_module.php
 * LEGAiSEE — Ingest & AI Memory Module
 *
 * Pattern: HTML fragment only — no DOCTYPE, no head, no body, no style tags
 * Styles:  ui/global.css — .card / .grid-2 / .stat-grid / .badge / .btn /
 *          table — promoted from ingest.php's proven design. This is now
 *          the system-wide standard layout, not a one-off ingest look.
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
                        (session_title, project_tag, source_ai, domain_id, project_id,
                         raw_transcript, word_count, context, created_at, processed)
                    VALUES
                        (:label, :tag, :platform, :domain_id, :project_id,
                         :raw_text, :word_count, 'memory', NOW(), 0)
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
                $stmt = $db->prepare("DELETE FROM memory_ingest WHERE id = :id");
                $stmt->execute([':id' => $del_id]);
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

// ── Recent sessions (always visible — not tab-gated) ───────────────────────────

$sessions = [];
try {
    $sessions = $db->query("
        SELECT id, session_title AS session_label, project_tag,
               source_ai AS platform, word_count, processed, created_at
        FROM memory_ingest ORDER BY created_at DESC LIMIT 10
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$active_tab = $_GET['tab'] ?? 'paste';
if (!in_array($active_tab, ['paste', 'upload'])) $active_tab = 'paste';

ob_start();
?>
<div>

    <?php if ($flash): ?>
        <?php if ($flash['type'] === 'ok'): ?>
        <div class="success">✔ <?= htmlspecialchars($flash['msg']) ?></div>
        <?php else: ?>
        <div class="error-msg">✘ <?= htmlspecialchars($flash['msg']) ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="gov-tabs" style="margin-bottom:24px">
        <a class="gov-tab <?= $active_tab === 'paste'  ? 'active' : '' ?>" href="?module=ingest&tab=paste">Paste AI Chat</a>
        <a class="gov-tab <?= $active_tab === 'upload' ? 'active' : '' ?>" href="?module=ingest&tab=upload">Upload File</a>
    </div>

    <div class="grid-2" style="align-items:start">

        <!-- LEFT: active form -->
        <div class="card">
            <div class="card-title"><?= $active_tab === 'upload' ? 'Upload File' : 'Ingest New Session' ?></div>

            <?php if ($active_tab !== 'upload'): ?>
            <form method="POST">
                <input type="hidden" name="ingest_action" value="paste_transcript">

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Session Label</label>
                        <input type="text" name="session_label" placeholder="e.g. Shell.php rebuild — May 13">
                    </div>
                    <div class="field">
                        <label>Platform</label>
                        <select name="platform">
                            <option value="claude">Claude (Anthropic)</option>
                            <option value="gemini">Gemini</option>
                            <option value="chatgpt">ChatGPT</option>
                            <option value="perplexity">Perplexity</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Project</label>
                        <select name="project_id">
                            <option value="">— Select —</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label>Domain</label>
                        <select name="domain_id">
                            <option value="">— Select —</option>
                            <?php foreach ($domains as $d): ?>
                                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Project Tag</label>
                    <input type="text" name="project_tag" value="commandcenter_build">
                </div>

                <div class="field">
                    <label>Full AI Session Transcript</label>
                    <textarea name="raw_text" style="min-height:240px"
                        placeholder="Paste the complete AI chat session here — all prompts and all responses."></textarea>
                </div>

                <button class="btn" type="submit">Store Session</button>
            </form>
            <?php else: ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ingest_action" value="upload_file">
                <div class="field">
                    <label>Select File to Upload</label>
                    <p style="color:#89612B;font-size:12px;margin-bottom:10px;line-height:1.5">
                        PDF, DOCX, TXT, JSON, images, and most other formats.
                        Stored in <code>data/files/</code> and registered in the files table.
                    </p>
                    <input type="file" name="upload_file">
                </div>
                <button class="btn" type="submit">Upload</button>
            </form>
            <?php endif; ?>
        </div>

        <!-- RIGHT: stats + recent sessions, always visible regardless of tab -->
        <div>
            <div class="card" style="margin-bottom:20px">
                <div class="card-title">Memory Bank</div>
                <div class="stat-grid">
                    <div class="stat"><span class="stat-num"><?= number_format($stat_sessions) ?></span><span class="stat-label">Sessions</span></div>
                    <div class="stat"><span class="stat-num"><?= number_format($stat_words) ?></span><span class="stat-label">Words</span></div>
                    <div class="stat"><span class="stat-num"><?= number_format($stat_files) ?></span><span class="stat-label">Files</span></div>
                    <div class="stat"><span class="stat-num"><?= number_format($stat_docs) ?></span><span class="stat-label">Docs</span></div>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Recent Ingests</div>
                <?php if (empty($sessions)): ?>
                <div style="color:#89612B;font-size:13px;padding:10px 0">No sessions yet — ingest your first one</div>
                <?php else: ?>
                <table>
                    <tr><th>Title</th><th>Source</th><th>Status</th><th></th></tr>
                    <?php foreach ($sessions as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['session_label'] ?: 'Untitled') ?></td>
                        <td><?= htmlspecialchars($s['platform'] ?: '—') ?></td>
                        <td>
                            <?php if (!empty($s['processed'])): ?>
                            <span class="badge badge-done">Processed</span>
                            <?php else: ?>
                            <span class="badge badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Delete session #<?= $s['id'] ?>?')">
                                <input type="hidden" name="ingest_action" value="delete_session">
                                <input type="hidden" name="session_id" value="<?= $s['id'] ?>">
                                <button class="gov-btn small danger" type="submit">Del</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?php
return ob_get_clean();