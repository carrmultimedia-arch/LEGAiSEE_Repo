<?php
/**
 * pm_module.php
 * LEGAiSEE — Project Manager Module
 *
 * Task board per project. Optional link back to memory_ingest
 * (an AI chat session can be "promoted" into a task).
 *
 * Pattern: HTML fragment only — no DOCTYPE, no head, no body, no style tags
 * Styles:  ui/global.css — .card / .grid-2 / .stat-grid / .badge / .btn / table
 * Loaded:  shell.php?module=pm
 * DB:      kernel_db() only
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

$db = kernel_db();

$STATUSES = ['Backlog', 'Architecting', 'Building', 'Review', 'Blocked', 'Done'];

function pm_badge_class(string $status): string {
    return 'badge-' . strtolower($status);
}

$flash = null;

// ── Handle form submissions ───────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['pm_action'] ?? '';

    if ($action === 'add_task') {
        $title       = trim($_POST['title'] ?? '');
        $project_id  = intval($_POST['project_id'] ?? 0) ?: null;
        $status      = in_array($_POST['status'] ?? '', $STATUSES) ? $_POST['status'] : 'Backlog';
        $priority    = intval($_POST['priority'] ?? 2);
        $due_date    = trim($_POST['due_date'] ?? '') ?: null;
        $detail      = trim($_POST['detail'] ?? '') ?: null;
        $ingest_id   = intval($_POST['source_ingest_id'] ?? 0) ?: null;

        if (!$title || !$project_id) {
            $flash = ['type' => 'error', 'msg' => 'Title and Project are required.'];
        } else {
            try {
                $stmt = $db->prepare("
                    INSERT INTO pm_tasks (project_id, title, detail, status, priority, due_date, source_ingest_id, created_at)
                    VALUES (:project_id, :title, :detail, :status, :priority, :due_date, :ingest_id, NOW())
                ");
                $stmt->execute([
                    ':project_id' => $project_id,
                    ':title'      => $title,
                    ':detail'     => $detail,
                    ':status'     => $status,
                    ':priority'   => $priority,
                    ':due_date'   => $due_date,
                    ':ingest_id'  => $ingest_id,
                ]);

                if ($ingest_id) {
                    $db->prepare("UPDATE memory_ingest SET processed = 1 WHERE id = :id")
                       ->execute([':id' => $ingest_id]);
                }

                $flash = ['type' => 'ok', 'msg' => "Task \"{$title}\" added."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'DB error: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'update_status') {
        $task_id = intval($_POST['task_id'] ?? 0);
        $status  = in_array($_POST['status'] ?? '', $STATUSES) ? $_POST['status'] : null;
        if ($task_id && $status) {
            try {
                $db->prepare("UPDATE pm_tasks SET status = :status WHERE id = :id")
                   ->execute([':status' => $status, ':id' => $task_id]);
                $flash = ['type' => 'ok', 'msg' => "Task #{$task_id} moved to {$status}."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Update failed: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'delete_task') {
        $task_id = intval($_POST['task_id'] ?? 0);
        if ($task_id) {
            try {
                $db->prepare("DELETE FROM pm_tasks WHERE id = :id")->execute([':id' => $task_id]);
                $flash = ['type' => 'ok', 'msg' => "Task #{$task_id} deleted."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Delete failed: ' . $e->getMessage()];
            }
        }
    }
}

// ── Projects (for dropdown + filter tabs) ───────────────────────────────────

$projects = [];
try { $projects = $db->query("SELECT id, name FROM projects ORDER BY name")->fetchAll(PDO::FETCH_ASSOC); } catch (Exception $e) {}

// ── Pending ingest sessions (for optional linking) ──────────────────────────

$pending_ingests = [];
try {
    $pending_ingests = $db->query("
        SELECT id, session_title, source_ai FROM memory_ingest
        WHERE processed = 0 ORDER BY created_at DESC LIMIT 20
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// ── Project filter ───────────────────────────────────────────────────────────

$filter_project = intval($_GET['project'] ?? 0);

// ── Stats (status counts, respecting filter) ─────────────────────────────────

$stat_counts = array_fill_keys($STATUSES, 0);
try {
    $sql = "SELECT status, COUNT(*) AS c FROM pm_tasks";
    $params = [];
    if ($filter_project) { $sql .= " WHERE project_id = :pid"; $params[':pid'] = $filter_project; }
    $sql .= " GROUP BY status";
    $rows = $db->prepare($sql);
    $rows->execute($params);
    foreach ($rows->fetchAll(PDO::FETCH_ASSOC) as $r) {
        if (isset($stat_counts[$r['status']])) $stat_counts[$r['status']] = (int)$r['c'];
    }
} catch (Exception $e) {}

// ── Task list ─────────────────────────────────────────────────────────────────

$tasks = [];
try {
    $sql = "
        SELECT t.id, t.title, t.status, t.priority, t.due_date, t.source_ingest_id,
               p.name AS project_name
        FROM pm_tasks t
        JOIN projects p ON p.id = t.project_id
    ";
    $params = [];
    if ($filter_project) { $sql .= " WHERE t.project_id = :pid"; $params[':pid'] = $filter_project; }
    $sql .= " ORDER BY t.priority DESC, t.due_date IS NULL, t.due_date ASC, t.created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$priority_labels = [1 => 'Low', 2 => 'Medium', 3 => 'High'];

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
        <a class="gov-tab <?= $filter_project === 0 ? 'active' : '' ?>" href="?module=pm">All Projects</a>
        <?php foreach ($projects as $p): ?>
        <a class="gov-tab <?= $filter_project === (int)$p['id'] ? 'active' : '' ?>" href="?module=pm&project=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="grid-2" style="align-items:start">

        <div class="card">
            <div class="card-title">New Task</div>
            <form method="POST">
                <input type="hidden" name="pm_action" value="add_task">

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="e.g. Finish brain excavation pipeline">
                </div>

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Project</label>
                        <select name="project_id">
                            <option value="">— Select —</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= $filter_project === (int)$p['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <?php foreach ($STATUSES as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Priority</label>
                        <select name="priority">
                            <option value="1">Low</option>
                            <option value="2" selected>Medium</option>
                            <option value="3">High</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Due Date</label>
                        <input type="date" name="due_date">
                    </div>
                </div>

                <?php if (!empty($pending_ingests)): ?>
                <div class="field">
                    <label>Link to AI Session (optional)</label>
                    <select name="source_ingest_id">
                        <option value="">— None —</option>
                        <?php foreach ($pending_ingests as $i): ?>
                            <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['session_title'] ?: 'Untitled') ?> (<?= htmlspecialchars($i['source_ai']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <p class="field-hint">Selecting a session marks it "Processed" in Memory Ingest.</p>
                </div>
                <?php endif; ?>

                <div class="field">
                    <label>Detail</label>
                    <textarea name="detail" style="min-height:120px" placeholder="Optional notes"></textarea>
                </div>

                <button class="btn" type="submit">Add Task</button>
            </form>
        </div>

        <div>
            <div class="card" style="margin-bottom:20px">
                <div class="card-title">Status Overview</div>
                <div class="stat-grid">
                    <?php foreach ($STATUSES as $s): ?>
                    <div class="stat">
                        <span class="stat-num"><?= $stat_counts[$s] ?></span>
                        <span class="stat-label"><?= $s ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Tasks<?= $filter_project ? '' : ' — All Projects' ?></div>
                <?php if (empty($tasks)): ?>
                <div style="color:#89612B;font-size:13px;padding:10px 0">No tasks yet — add the first one.</div>
                <?php else: ?>
                <table>
                    <tr><th>Title</th><th>Project</th><th>Status</th><th>Priority</th><th>Due</th><th></th><th></th></tr>
                    <?php foreach ($tasks as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['title']) ?><?= $t['source_ingest_id'] ? ' <span class="badge badge-backlog" title="Linked to an AI session">AI</span>' : '' ?></td>
                        <td><?= htmlspecialchars($t['project_name']) ?></td>
                        <td><span class="badge <?= pm_badge_class($t['status']) ?>"><?= htmlspecialchars($t['status']) ?></span></td>
                        <td><?= $priority_labels[(int)$t['priority']] ?? '—' ?></td>
                        <td><?= $t['due_date'] ? htmlspecialchars($t['due_date']) : '—' ?></td>
                        <td>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="pm_action" value="update_status">
                                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                                <select name="status" onchange="this.form.submit()" style="padding:4px 8px;font-size:11px;border-radius:8px">
                                    <?php foreach ($STATUSES as $s): ?>
                                        <option value="<?= $s ?>" <?= $s === $t['status'] ? 'selected' : '' ?>><?= $s ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Delete task #<?= $t['id'] ?>?')">
                                <input type="hidden" name="pm_action" value="delete_task">
                                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
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
