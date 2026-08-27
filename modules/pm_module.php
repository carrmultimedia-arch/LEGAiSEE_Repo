<?php
/**
 * pm_module.php
 * LEGAiSEE — Project Manager Module
 *
 * Single-page workspace: persistent sidebar (project list + new project),
 * main panel with instant JS-toggled List / Board views (no reload between
 * views — only changing the project filter reloads, since that re-queries).
 *
 * Pattern: HTML fragment only — no DOCTYPE, no head, no body, no <style> tags
 * Styles:  ui/global.css — .card / .grid-2 / .stat-grid / .badge / .btn / table
 * Loaded:  shell.php?module=pm
 * DB:      kernel_db() only
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

$db = kernel_db();

$STATUSES = ['Backlog', 'Architecting', 'Building', 'Review', 'Blocked', 'Done'];
// Project lifecycle. Existing values (active, on_hold, completed, archived)
// stay valid so nothing already in the DB breaks — the new stages
// (intake, approved, planning, at_risk) extend it into a real lifecycle
// for the project-level board.
$PROJECT_STATUSES = ['intake', 'approved', 'planning', 'active', 'on_hold', 'at_risk', 'review', 'completed', 'archived'];
$PROJECT_STATUS_LABELS = [
    'intake'    => 'Intake',
    'approved'  => 'Approved',
    'planning'  => 'Planning',
    'active'    => 'Active',
    'on_hold'   => 'On Hold',
    'at_risk'   => 'At Risk',
    'review'    => 'Review',
    'completed' => 'Completed',
    'archived'  => 'Archived',
];

function pm_badge_class(string $status): string {
    return 'badge-' . strtolower($status);
}

function project_badge_class(string $status): string {
    $map = [
        'intake'    => 'badge-backlog',
        'approved'  => 'badge-backlog',
        'planning'  => 'badge-architecting',
        'active'    => 'badge-building',
        'on_hold'   => 'badge-blocked',
        'at_risk'   => 'badge-blocked',
        'review'    => 'badge-review',
        'completed' => 'badge-done',
        'archived'  => 'badge-backlog',
    ];
    return $map[$status] ?? 'badge-backlog';
}

/**
 * Generate a URL-safe slug from a project name, unique against `projects`.
 */
function pm_generate_unique_slug(PDO $db, string $name): string {
    $base = strtolower(trim($name));
    $base = preg_replace('/[^a-z0-9]+/', '-', $base);
    $base = trim($base, '-');
    if ($base === '') $base = 'project';

    $slug = $base;
    $i = 2;
    $stmt = $db->prepare("SELECT COUNT(*) FROM projects WHERE slug = :slug");
    while (true) {
        $stmt->execute([':slug' => $slug]);
        if ((int)$stmt->fetchColumn() === 0) break;
        $slug = $base . '-' . $i;
        $i++;
    }
    return $slug;
}

$flash = null;

// ── Handle form submissions ───────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['pm_action'] ?? '';

    // ── Project actions ─────────────────────────────────────────────────────
    if ($action === 'add_project') {
        $name        = trim($_POST['name'] ?? '');
        $description = trim($_POST['detail'] ?? '') ?: null;
        $status      = in_array($_POST['status'] ?? '', $PROJECT_STATUSES) ? $_POST['status'] : 'active';

        if (!$name) {
            $flash = ['type' => 'error', 'msg' => 'Project name is required.'];
        } else {
            try {
                $slug = pm_generate_unique_slug($db, $name);
                $stmt = $db->prepare("
                    INSERT INTO projects (name, slug, description, status, created_at)
                    VALUES (:name, :slug, :description, :status, NOW())
                ");
                $stmt->execute([
                    ':name'        => $name,
                    ':slug'        => $slug,
                    ':description' => $description,
                    ':status'      => $status,
                ]);
                $flash = ['type' => 'ok', 'msg' => "Project \"{$name}\" created."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'DB error: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'update_project_status') {
        $project_id = intval($_POST['project_id'] ?? 0);
        $status     = in_array($_POST['status'] ?? '', $PROJECT_STATUSES) ? $_POST['status'] : null;
        if ($project_id && $status) {
            try {
                $db->prepare("UPDATE projects SET status = :status WHERE id = :id")
                   ->execute([':status' => $status, ':id' => $project_id]);
                $flash = ['type' => 'ok', 'msg' => "Project #{$project_id} status updated."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Update failed: ' . $e->getMessage()];
            }
        }
    }

    // ── Task actions ───────────────────────────────────────────────────────
    if ($action === 'add_task') {
        $title       = trim($_POST['title'] ?? '');
        $project_id  = intval($_POST['project_id'] ?? 0) ?: null;
        $status      = in_array($_POST['status'] ?? '', $STATUSES) ? $_POST['status'] : 'Backlog';
        $priority    = intval($_POST['priority'] ?? 2);
        $due_date    = trim($_POST['due_date'] ?? '') ?: null;
        $detail      = trim($_POST['detail'] ?? '') ?: null;
        $blocked_reason = trim($_POST['blocked_reason'] ?? '') ?: null;
        $ingest_ids  = $_POST['ingest_ids'] ?? [];

        // Guard against a stale/invalid project_id — fail soft, task still
        // gets created (unlinked) instead of a raw FK constraint error.
        $project_warning = null;
        if ($project_id) {
            $check = $db->prepare("SELECT COUNT(*) FROM projects WHERE id = :id");
            $check->execute([':id' => $project_id]);
            if ((int)$check->fetchColumn() === 0) {
                $project_id = null;
                $project_warning = 'Selected project no longer exists — task was created without a project link. Please reload the page.';
            }
        }

        if (!$title) {
            $flash = ['type' => 'error', 'msg' => 'Title is required.'];
        } else {
            try {
                $stmt = $db->prepare("
                    INSERT INTO pm_tasks (project_id, title, detail, status, priority, due_date, blocked_reason, created_at)
                    VALUES (:project_id, :title, :detail, :status, :priority, :due_date, :blocked_reason, NOW())
                ");
                $stmt->execute([
                    ':project_id' => $project_id,
                    ':title'      => $title,
                    ':detail'     => $detail,
                    ':status'     => $status,
                    ':priority'   => $priority,
                    ':due_date'   => $due_date,
                    ':blocked_reason' => $blocked_reason,
                ]);
                $task_id = $db->lastInsertId();

                foreach ($ingest_ids as $ingest_id) {
                    $ingest_id = intval($ingest_id);
                    if ($ingest_id) {
                        try {
                            $link_stmt = $db->prepare("
                                INSERT INTO task_sessions (task_id, session_id, linked_at)
                                VALUES (:task_id, :session_id, NOW())
                            ");
                            $link_stmt->execute([
                                ':task_id' => $task_id,
                                ':session_id' => $ingest_id,
                            ]);

                            $db->prepare("UPDATE memory_ingest SET processed = 1 WHERE id = :id")
                               ->execute([':id' => $ingest_id]);
                        } catch (Exception $e) {
                            // Ignore duplicate links (unique constraint)
                        }
                    }
                }

                $flash = $project_warning
                    ? ['type' => 'error', 'msg' => "Task \"{$title}\" added, but: {$project_warning}"]
                    : ['type' => 'ok', 'msg' => "Task \"{$title}\" added."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'DB error: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'add_session_link') {
        $task_id    = intval($_POST['task_id'] ?? 0);
        $ingest_id  = intval($_POST['ingest_id'] ?? 0);
        if ($task_id && $ingest_id) {
            try {
                $stmt = $db->prepare("
                    INSERT INTO task_sessions (task_id, session_id, linked_at)
                    VALUES (:task_id, :session_id, NOW())
                ");
                $stmt->execute([
                    ':task_id' => $task_id,
                    ':session_id' => $ingest_id,
                ]);

                $db->prepare("UPDATE memory_ingest SET processed = 1 WHERE id = :id")
                   ->execute([':id' => $ingest_id]);

                $flash = ['type' => 'ok', 'msg' => "Session linked to task #{$task_id}."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Link failed (may already exist): ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'remove_session_link') {
        $link_id = intval($_POST['link_id'] ?? 0);
        if ($link_id) {
            try {
                $db->prepare("DELETE FROM task_sessions WHERE link_id = :id")->execute([':id' => $link_id]);
                $flash = ['type' => 'ok', 'msg' => "Session link removed."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Remove failed: ' . $e->getMessage()];
            }
        }
    }

    if ($action === 'update_task') {
        $task_id    = intval($_POST['task_id'] ?? 0);
        $title      = trim($_POST['title'] ?? '');
        $detail     = trim($_POST['detail'] ?? '') ?: null;
        $status     = in_array($_POST['status'] ?? '', $STATUSES) ? $_POST['status'] : null;
        $priority   = intval($_POST['priority'] ?? 2);
        $due_date   = trim($_POST['due_date'] ?? '') ?: null;
        $project_id = intval($_POST['project_id'] ?? 0) ?: null;
        $blocked_reason = trim($_POST['blocked_reason'] ?? '') ?: null;

        if ($project_id) {
            $check = $db->prepare("SELECT COUNT(*) FROM projects WHERE id = :id");
            $check->execute([':id' => $project_id]);
            if ((int)$check->fetchColumn() === 0) $project_id = null;
        }

        if ($task_id && $title && $status) {
            try {
                $stmt = $db->prepare("
                    UPDATE pm_tasks
                    SET title = :title, detail = :detail, status = :status,
                        priority = :priority, due_date = :due_date, project_id = :project_id,
                        blocked_reason = :blocked_reason
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':title'      => $title,
                    ':detail'     => $detail,
                    ':status'     => $status,
                    ':priority'   => $priority,
                    ':due_date'   => $due_date,
                    ':project_id' => $project_id,
                    ':blocked_reason' => $blocked_reason,
                    ':id'         => $task_id,
                ]);
                $flash = ['type' => 'ok', 'msg' => "Task #{$task_id} updated."];
            } catch (Exception $e) {
                $flash = ['type' => 'error', 'msg' => 'Update failed: ' . $e->getMessage()];
            }
        } else {
            $flash = ['type' => 'error', 'msg' => 'Title and status are required.'];
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

// ── Projects (sidebar list) ─────────────────────────────────────────────────

$projects = [];
try { $projects = $db->query("SELECT id, name, status FROM projects ORDER BY name")->fetchAll(PDO::FETCH_ASSOC); } catch (Exception $e) {}

$project_task_counts = [];
try {
    $counts = $db->query("SELECT project_id, COUNT(*) AS c FROM pm_tasks GROUP BY project_id")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($counts as $c) {
        $project_task_counts[$c['project_id']] = (int)$c['c'];
    }
} catch (Exception $e) {}

// ── Pending ingest sessions (for optional linking) ──────────────────────────

$pending_ingests = [];
try {
    $pending_ingests = $db->query("
        SELECT id, session_title, source_ai FROM memory_ingest
        WHERE processed = 0 ORDER BY created_at DESC LIMIT 20
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// ── Project filter (sidebar selection — reloads, re-queries) ────────────────

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
$task_sessions = [];
try {
    $sql = "
        SELECT t.id, t.title, t.detail, t.status, t.priority, t.due_date, t.project_id, t.blocked_reason,
               p.name AS project_name
        FROM pm_tasks t
        LEFT JOIN projects p ON p.id = t.project_id
    ";
    $params = [];
    if ($filter_project) { $sql .= " WHERE t.project_id = :pid"; $params[':pid'] = $filter_project; }
    $sql .= " ORDER BY t.priority DESC, t.due_date IS NULL, t.due_date ASC, t.created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($tasks)) {
        $task_ids = array_column($tasks, 'id');
        $placeholders = implode(',', array_fill(0, count($task_ids), '?'));
        $session_sql = "
            SELECT ts.link_id, ts.task_id, ts.session_id, ts.linked_at,
                   mi.session_title, mi.source_ai
            FROM task_sessions ts
            LEFT JOIN memory_ingest mi ON mi.id = ts.session_id
            WHERE ts.task_id IN ($placeholders)
            ORDER BY ts.linked_at DESC
        ";
        $session_stmt = $db->prepare($session_sql);
        $session_stmt->execute($task_ids);
        $session_rows = $session_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($session_rows as $row) {
            $task_sessions[$row['task_id']][] = $row;
        }
    }
} catch (Exception $e) {}

$priority_labels = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
$current_project_name = $filter_project
    ? (array_values(array_filter($projects, fn($p) => (int)$p['id'] === $filter_project))[0]['name'] ?? 'Project')
    : 'All Projects';

// Payload for the task detail modal — avoids a round trip on click.
$tasks_json = [];
foreach ($tasks as $t) {
    $sess = [];
    foreach (($task_sessions[$t['id']] ?? []) as $s) {
        $sess[] = [
            'link_id' => $s['link_id'],
            'title'   => $s['session_title'] ?: 'Untitled',
            'source'  => $s['source_ai'],
        ];
    }
    $tasks_json[$t['id']] = [
        'id'         => (int)$t['id'],
        'title'      => $t['title'],
        'detail'     => $t['detail'],
        'status'     => $t['status'],
        'priority'   => (int)$t['priority'],
        'due_date'   => $t['due_date'],
        'project_id' => $t['project_id'],
        'blocked_reason' => $t['blocked_reason'],
        'sessions'   => $sess,
    ];
}

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

    <div style="display:flex;gap:20px;align-items:flex-start">

        <!-- ═══ SIDEBAR — persistent, always visible ═══ -->
        <div class="card" style="width:220px;flex:0 0 220px;position:sticky;top:16px">
            <div class="card-title">Projects</div>

            <div style="display:flex;flex-direction:column;gap:2px;margin-bottom:14px">
                <a href="?module=pm<?= '' ?>"
                   style="display:flex;justify-content:space-between;padding:7px 8px;border-radius:8px;text-decoration:none;font-size:13px;
                          background:<?= $filter_project === 0 ? 'rgba(201,169,97,0.15)' : 'transparent' ?>;
                          color:<?= $filter_project === 0 ? '#C9A961' : '#CDAD69' ?>">
                    <span>All Projects</span>
                </a>
                <?php foreach ($projects as $p): ?>
                <a href="?module=pm&project=<?= $p['id'] ?>"
                   style="display:flex;justify-content:space-between;padding:7px 8px;border-radius:8px;text-decoration:none;font-size:13px;
                          background:<?= $filter_project === (int)$p['id'] ? 'rgba(201,169,97,0.15)' : 'transparent' ?>;
                          color:<?= $filter_project === (int)$p['id'] ? '#C9A961' : '#CDAD69' ?>">
                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars($p['name']) ?></span>
                    <span style="color:#666;flex-shrink:0;margin-left:6px"><?= $project_task_counts[$p['id']] ?? 0 ?></span>
                </a>
                <?php endforeach; ?>
            </div>

            <button class="btn" type="button" style="width:100%;font-size:12px" onclick="pmToggleNewProject()">+ New Project</button>

            <div id="pm-new-project-form" style="display:none;margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.06)">
                <form method="POST">
                    <input type="hidden" name="pm_action" value="add_project">
                    <div class="field">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Project name">
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <?php foreach ($PROJECT_STATUSES as $s): ?>
                                <option value="<?= $s ?>" <?= $s === 'intake' ? 'selected' : '' ?>><?= $PROJECT_STATUS_LABELS[$s] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <textarea name="detail" style="min-height:60px" placeholder="Optional"></textarea>
                    </div>
                    <button class="btn" type="submit" style="width:100%">Create</button>
                </form>
            </div>

            <?php if ($filter_project): ?>
            <div style="margin-top:14px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.06)">
                <?php
                $cur = array_values(array_filter($projects, fn($p) => (int)$p['id'] === $filter_project));
                $cur = $cur[0] ?? null;
                ?>
                <?php if ($cur): ?>
                <form method="POST">
                    <input type="hidden" name="pm_action" value="update_project_status">
                    <input type="hidden" name="project_id" value="<?= $cur['id'] ?>">
                    <label style="font-size:11px;color:#89612B">Project Status</label>
                    <select name="status" onchange="this.form.submit()" style="width:100%;margin-top:4px">
                        <?php foreach ($PROJECT_STATUSES as $s): ?>
                            <option value="<?= $s ?>" <?= $s === $cur['status'] ? 'selected' : '' ?>><?= $PROJECT_STATUS_LABELS[$s] ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ═══ MAIN WORKSPACE ═══ -->
        <div style="flex:1;min-width:0">

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                <div style="font-size:16px;color:#C9A961"><?= htmlspecialchars($current_project_name) ?></div>
                <div style="display:flex;gap:8px">
                    <button class="gov-tab active" type="button" id="pm-tab-list-btn" onclick="pmSwitchView('list')">List</button>
                    <button class="gov-tab" type="button" id="pm-tab-board-btn" onclick="pmSwitchView('board')">Board</button>
                    <button class="gov-tab" type="button" id="pm-tab-pboard-btn" onclick="pmSwitchView('pboard')">Projects Board</button>
                </div>
            </div>

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

            <!-- ─── LIST VIEW ─── -->
            <div id="pm-view-list">

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
                                        <option value="">— None / Backlog —</option>
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
                                <label>Link to AI Sessions (optional)</label>
                                <div style="max-height:130px;overflow-y:auto;background:rgba(10,10,12,0.5);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:12px">
                                    <?php foreach ($pending_ingests as $i): ?>
                                    <div style="margin-bottom:8px">
                                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                                            <input type="checkbox" name="ingest_ids[]" value="<?= $i['id'] ?>" style="width:auto;margin:0">
                                            <span style="font-size:12px;color:#CDAD69"><?= htmlspecialchars($i['session_title'] ?: 'Untitled') ?> (<?= htmlspecialchars($i['source_ai']) ?>)</span>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="field">
                                <label>Detail</label>
                                <textarea name="detail" style="min-height:100px" placeholder="Optional notes"></textarea>
                            </div>

                            <button class="btn" type="submit">Add Task</button>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-title">Tasks</div>
                        <?php if (empty($tasks)): ?>
                        <div style="color:#89612B;font-size:13px;padding:10px 0">No tasks yet — add the first one.</div>
                        <?php else: ?>
                        <table>
                            <tr><th>Title</th><th>Project</th><th>Status</th><th>Priority</th><th>Due</th><th>Sessions</th><th></th><th></th></tr>
                            <?php foreach ($tasks as $t): ?>
                            <tr>
                                <td>
                                    <a href="javascript:void(0)" onclick="pmOpenTask(<?= $t['id'] ?>)" style="color:#C9A961;text-decoration:none">
                                        <?= htmlspecialchars($t['title']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($t['project_name'] ?? '—') ?></td>
                                <td><span class="badge <?= pm_badge_class($t['status']) ?>"><?= htmlspecialchars($t['status']) ?></span></td>
                                <td><?= $priority_labels[(int)$t['priority']] ?? '—' ?></td>
                                <td><?= $t['due_date'] ? htmlspecialchars($t['due_date']) : '—' ?></td>
                                <td>
                                    <?php $sessions = $task_sessions[$t['id']] ?? []; ?>
                                    <?php if (empty($sessions)): ?>
                                        <span style="color:#666;font-size:11px">—</span>
                                    <?php else: ?>
                                        <div style="font-size:11px">
                                            <?php foreach ($sessions as $s): ?>
                                            <div style="margin-bottom:4px">
                                                <span class="badge badge-backlog" title="<?= htmlspecialchars($s['session_title'] ?: 'Untitled') ?>">AI</span>
                                                <span style="color:#89612B;margin-left:4px"><?= htmlspecialchars(substr($s['session_title'] ?: 'Untitled', 0, 20)) ?>...</span>
                                                <form method="POST" style="display:inline;margin-left:4px" onsubmit="return confirm('Remove session link?')">
                                                    <input type="hidden" name="pm_action" value="remove_session_link">
                                                    <input type="hidden" name="link_id" value="<?= $s['link_id'] ?>">
                                                    <button style="background:none;border:none;color:#666;cursor:pointer;font-size:10px;padding:0" type="submit">×</button>
                                                </form>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
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

            <!-- ─── BOARD VIEW (hidden by default, toggled by JS, no reload) ─── -->
            <div id="pm-view-board" style="display:none">
                <div style="display:flex;gap:14px;overflow-x:auto;padding-bottom:16px;align-items:flex-start">
                    <?php foreach ($STATUSES as $s): ?>
                    <div class="card" data-status="<?= $s ?>" ondragover="pmAllowDrop(event)" ondrop="pmDrop(event)"
                         style="min-width:230px;max-width:230px;flex:0 0 230px;max-height:70vh;overflow-y:auto;padding:12px">
                        <div class="card-title" style="display:flex;justify-content:space-between;align-items:center">
                            <span><?= $s ?></span>
                            <span class="badge <?= pm_badge_class($s) ?>"><?= $stat_counts[$s] ?></span>
                        </div>
                        <div class="pm-board-col" style="min-height:40px">
                            <?php foreach ($tasks as $t): if ($t['status'] !== $s) continue; ?>
                            <div class="card" draggable="true" ondragstart="pmDragStart(event)" data-task-id="<?= $t['id'] ?>"
                                 style="margin:10px 0 0;padding:10px;cursor:grab;background:rgba(255,255,255,0.03)">
                                <div style="font-size:13px;line-height:1.3;margin-bottom:6px;cursor:pointer" onclick="pmOpenTask(<?= $t['id'] ?>)"><?= htmlspecialchars($t['title']) ?></div>
                                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#89612B">
                                    <span><?= htmlspecialchars($t['project_name'] ?? '—') ?></span>
                                    <span><?= $priority_labels[(int)$t['priority']] ?? '' ?></span>
                                </div>
                                <?php if ($t['due_date']): ?>
                                <div style="font-size:11px;color:#89612B;margin-top:4px">Due <?= htmlspecialchars($t['due_date']) ?></div>
                                <?php endif; ?>
                                <?php if ($t['status'] === 'Blocked' && $t['blocked_reason']): ?>
                                <div style="font-size:11px;color:#C97A61;margin-top:4px;padding-top:4px;border-top:1px solid rgba(255,255,255,0.06)">⛔ <?= htmlspecialchars($t['blocked_reason']) ?></div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ─── PROJECTS BOARD (projects as cards, lifecycle columns) ─── -->
            <div id="pm-view-pboard" style="display:none">
                <div style="display:flex;gap:14px;overflow-x:auto;padding-bottom:16px;align-items:flex-start">
                    <?php foreach ($PROJECT_STATUSES as $ps): ?>
                    <?php $ps_projects = array_values(array_filter($projects, fn($p) => $p['status'] === $ps)); ?>
                    <div class="card" data-pstatus="<?= $ps ?>" ondragover="pmAllowDrop(event)" ondrop="pmProjectDrop(event)"
                         style="min-width:220px;max-width:220px;flex:0 0 220px;max-height:70vh;overflow-y:auto;padding:12px">
                        <div class="card-title" style="display:flex;justify-content:space-between;align-items:center">
                            <span><?= $PROJECT_STATUS_LABELS[$ps] ?></span>
                            <span class="badge <?= project_badge_class($ps) ?>"><?= count($ps_projects) ?></span>
                        </div>
                        <div class="pm-pboard-col" style="min-height:40px">
                            <?php foreach ($ps_projects as $p): ?>
                            <div class="card" draggable="true" ondragstart="pmProjectDragStart(event)" data-project-id="<?= $p['id'] ?>"
                                 style="margin:10px 0 0;padding:10px;cursor:grab;background:rgba(255,255,255,0.03)">
                                <div style="font-size:13px;line-height:1.3;margin-bottom:6px"><?= htmlspecialchars($p['name']) ?></div>
                                <div style="font-size:11px;color:#89612B"><?= $project_task_counts[$p['id']] ?? 0 ?> task<?= ($project_task_counts[$p['id']] ?? 0) === 1 ? '' : 's' ?></div>
                            </div>
                            <?php endforeach; ?>
                            <?php if (empty($ps_projects)): ?>
                            <div style="font-size:11px;color:#555;padding:8px 0">—</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- ═══ TASK DETAIL MODAL ═══ -->
    <div id="pm-task-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:1000" onclick="if(event.target===this)pmCloseTask()">
        <div class="card" style="position:absolute;top:8%;left:50%;transform:translateX(-50%);width:480px;max-width:92vw;max-height:82vh;overflow-y:auto;padding:20px">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
                <div class="card-title" style="margin:0">Task Detail</div>
                <button type="button" onclick="pmCloseTask()" style="background:none;border:none;color:#89612B;font-size:18px;cursor:pointer;line-height:1">×</button>
            </div>

            <form method="POST" id="pm-task-form">
                <input type="hidden" name="pm_action" value="update_task">
                <input type="hidden" name="task_id" id="pm-modal-task-id">

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" id="pm-modal-title">
                </div>

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Project</label>
                        <select name="project_id" id="pm-modal-project">
                            <option value="">— None / Backlog —</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status" id="pm-modal-status">
                            <?php foreach ($STATUSES as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Priority</label>
                        <select name="priority" id="pm-modal-priority">
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Due Date</label>
                        <input type="date" name="due_date" id="pm-modal-due">
                    </div>
                </div>

                <div class="field" id="pm-modal-blocked-wrap">
                    <label>Blocked Reason</label>
                    <input type="text" name="blocked_reason" id="pm-modal-blocked" placeholder="Why is this blocked?">
                </div>

                <div class="field">
                    <label>Detail</label>
                    <textarea name="detail" id="pm-modal-detail" style="min-height:120px"></textarea>
                </div>

                <div id="pm-modal-sessions" style="margin-bottom:14px"></div>

                <div style="display:flex;justify-content:space-between;align-items:center">
                    <button type="submit" class="btn">Save Changes</button>
                    <button type="button" class="gov-btn small danger" onclick="pmDeleteFromModal()">Delete Task</button>
                </div>
            </form>
        </div>
    </div>

    <form method="POST" id="pm-modal-delete-form" style="display:none">
        <input type="hidden" name="pm_action" value="delete_task">
        <input type="hidden" name="task_id" id="pm-modal-delete-id">
    </form>

    <script>
    var pmTasksData = <?= json_encode($tasks_json, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    function pmOpenTask(id) {
        var t = pmTasksData[id];
        if (!t) return;
        document.getElementById('pm-modal-task-id').value = t.id;
        document.getElementById('pm-modal-title').value = t.title || '';
        document.getElementById('pm-modal-project').value = t.project_id || '';
        document.getElementById('pm-modal-status').value = t.status || 'Backlog';
        document.getElementById('pm-modal-priority').value = t.priority || 2;
        document.getElementById('pm-modal-due').value = t.due_date || '';
        document.getElementById('pm-modal-detail').value = t.detail || '';
        document.getElementById('pm-modal-delete-id').value = t.id;
        document.getElementById('pm-modal-blocked').value = t.blocked_reason || '';
        document.getElementById('pm-modal-blocked-wrap').style.display = (t.status === 'Blocked') ? 'block' : 'none';

        var sessHtml = '';
        if (t.sessions && t.sessions.length) {
            sessHtml += '<label style="font-size:11px;color:#89612B">Linked AI Sessions</label><div style="margin-top:6px">';
            t.sessions.forEach(function (s) {
                sessHtml += '<div style="font-size:12px;color:#CDAD69;margin-bottom:4px">' +
                    '<span class="badge badge-backlog">AI</span> ' +
                    s.title.replace(/</g, '&lt;') + ' (' + s.source.replace(/</g, '&lt;') + ')</div>';
            });
            sessHtml += '</div>';
        }
        document.getElementById('pm-modal-sessions').innerHTML = sessHtml;

        document.getElementById('pm-task-modal-overlay').style.display = 'block';
    }

    document.getElementById('pm-modal-status').addEventListener('change', function () {
        document.getElementById('pm-modal-blocked-wrap').style.display = (this.value === 'Blocked') ? 'block' : 'none';
    });

    function pmCloseTask() {
        document.getElementById('pm-task-modal-overlay').style.display = 'none';
    }

    function pmDeleteFromModal() {
        if (!confirm('Delete this task? This cannot be undone.')) return;
        document.getElementById('pm-modal-delete-form').submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') pmCloseTask();
    });
    </script>

    <script>
    function pmToggleNewProject() {
        var el = document.getElementById('pm-new-project-form');
        el.style.display = (el.style.display === 'none' || !el.style.display) ? 'block' : 'none';
    }
    function pmSwitchView(view) {
        var views = {
            list: document.getElementById('pm-view-list'),
            board: document.getElementById('pm-view-board'),
            pboard: document.getElementById('pm-view-pboard')
        };
        var btns = {
            list: document.getElementById('pm-tab-list-btn'),
            board: document.getElementById('pm-tab-board-btn'),
            pboard: document.getElementById('pm-tab-pboard-btn')
        };
        Object.keys(views).forEach(function (key) {
            views[key].style.display = (key === view) ? 'block' : 'none';
            if (key === view) { btns[key].classList.add('active'); }
            else { btns[key].classList.remove('active'); }
        });
    }
    function pmDragStart(e) {
        e.dataTransfer.setData('text/plain', e.currentTarget.getAttribute('data-task-id'));
    }
    function pmAllowDrop(e) {
        e.preventDefault();
    }
    function pmDrop(e) {
        e.preventDefault();
        var taskId = e.dataTransfer.getData('text/plain');
        var col = e.currentTarget;
        var status = col.getAttribute('data-status');
        var card = document.querySelector('[data-task-id="' + taskId + '"]');
        if (card) {
            col.querySelector('.pm-board-col').appendChild(card);
        }
        var fd = new FormData();
        fd.append('pm_action', 'update_status');
        fd.append('task_id', taskId);
        fd.append('status', status);
        fetch(window.location.href, { method: 'POST', body: fd })
            .catch(function () { window.location.reload(); });
    }
    function pmProjectDragStart(e) {
        e.dataTransfer.setData('text/plain', e.currentTarget.getAttribute('data-project-id'));
    }
    function pmProjectDrop(e) {
        e.preventDefault();
        var projectId = e.dataTransfer.getData('text/plain');
        var col = e.currentTarget;
        var status = col.getAttribute('data-pstatus');
        var card = document.querySelector('[data-project-id="' + projectId + '"]');
        if (card) {
            col.querySelector('.pm-pboard-col').appendChild(card);
        }
        var fd = new FormData();
        fd.append('pm_action', 'update_project_status');
        fd.append('project_id', projectId);
        fd.append('status', status);
        fetch(window.location.href, { method: 'POST', body: fd })
            .catch(function () { window.location.reload(); });
    }
    </script>

</div>
<?php
return ob_get_clean();