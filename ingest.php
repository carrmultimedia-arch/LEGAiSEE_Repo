<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/kernel/kernel_boot.php';

$db = kernel_db();
$message = '';

/* =====================================================
   INGEST HANDLER
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['raw_transcript'])) {
    try {
        $stmt = $db->prepare("
            INSERT INTO memory_ingest
            (domain_id, project_id, source_ai, session_title, raw_transcript)
            VALUES (:domain_id, :project_id, :source_ai, :session_title, :raw_transcript)
        ");
        $stmt->execute([
            ':domain_id'      => $_POST['domain_id'] ?? null,
            ':project_id'     => $_POST['project_id'] ?? null,
            ':source_ai'      => $_POST['source_ai'] ?? 'ChatGPT',
            ':session_title'  => $_POST['session_title'] ?? '',
            ':raw_transcript' => $_POST['raw_transcript']
        ]);
        $message = 'success';
    } catch (Throwable $e) {
        $message = 'error:' . $e->getMessage();
    }
}

/* =====================================================
   LOAD DROPDOWNS
===================================================== */

$domains  = $db->query("SELECT id, name FROM memory_domains ORDER BY name ASC")->fetchAll();
$projects = $db->query("SELECT id, name FROM projects ORDER BY name ASC")->fetchAll();

function opts(array $rows): string {
    $html = "<option value=''>— Select —</option>";
    foreach ($rows as $r) {
        $html .= "<option value='" . htmlspecialchars((string)$r['id']) . "'>"
               . htmlspecialchars($r['name']) . "</option>";
    }
    return $html;
}

/* =====================================================
   LATEST INGESTS
===================================================== */

$latest = $db->query("
    SELECT id, session_title, source_ai, created_at, processed
    FROM memory_ingest
    ORDER BY id DESC LIMIT 10
")->fetchAll();

$total = $db->query("SELECT COUNT(*) FROM memory_ingest")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LEGAiSEE — Memory Ingest</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#0a0a0c;color:#CDAD69;padding:0;min-height:100vh;
background:linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.85)),url('/commandcenter/ui/images/dark-room-with-black-wall-black-wall-with-carved-design_902639-63079-upscale-4x.jpg') center/cover fixed}
.topbar{position:sticky;top:0;z-index:100;height:72px;display:flex;align-items:center;justify-content:space-between;padding:0 40px;
backdrop-filter:blur(18px);background:linear-gradient(rgba(10,10,10,0.65),rgba(10,10,10,0.40));border-bottom:1px solid rgba(255,255,255,0.05)}
.brand{font-size:16px;letter-spacing:4px;color:#F4E185;font-weight:300}
.brand-sub{font-size:10px;letter-spacing:2px;color:#89612B;text-transform:uppercase;margin-top:3px}
.nav a{text-decoration:none;color:#CDAD69;padding:8px 16px;border-radius:999px;border:1px solid rgba(255,255,255,0.05);margin-left:10px;font-size:13px;transition:.3s}
.nav a:hover{color:#F4E185;border-color:rgba(230,194,86,0.3)}
.wrap{max-width:1200px;margin:auto;padding:50px 40px 100px}
.page-title{font-size:42px;font-weight:200;color:#F4E185;letter-spacing:2px;margin-bottom:8px}
.page-sub{color:#89612B;font-size:13px;letter-spacing:2px;text-transform:uppercase;margin-bottom:40px}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:28px}
.card{background:rgba(22,22,24,0.82);border:1px solid rgba(255,255,255,0.06);border-radius:20px;padding:28px;backdrop-filter:blur(12px)}
.card-title{font-size:13px;letter-spacing:2px;text-transform:uppercase;color:#89612B;margin-bottom:20px}
.field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px}
.field label{font-size:11px;color:#89612B;text-transform:uppercase;letter-spacing:1px}
.field input,.field select,.field textarea{
padding:10px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);
.field select option{
    background: #111111; color: #F4E185;}
background:rgba(255,255,255,0.04);color:#F4E185;font-size:14px;font-family:inherit;width:100%}
.field textarea{min-height:220px;resize:vertical;line-height:1.6}
.field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:rgba(230,194,86,0.4)}
.full{grid-column:1/-1}
.btn{width:100%;padding:14px;border-radius:999px;border:none;background:linear-gradient(135deg,#e6c256,#ce9008);
color:#111;font-weight:700;font-size:15px;cursor:pointer;letter-spacing:1px;margin-top:8px;transition:.3s}
.btn:hover{opacity:.9;transform:translateY(-1px)}
.success{background:rgba(74,222,128,0.08);border:1px solid rgba(74,222,128,0.25);border-radius:10px;padding:12px 18px;color:#86efac;margin-bottom:20px;font-size:14px}
.error-msg{background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.25);border-radius:10px;padding:12px 18px;color:#fca5a5;margin-bottom:20px;font-size:14px}
table{width:100%;border-collapse:collapse;font-size:13px}
th{color:#89612B;text-align:left;padding:8px 10px;border-bottom:1px solid rgba(255,255,255,0.08);font-size:11px;letter-spacing:1px;text-transform:uppercase}
td{padding:10px;border-bottom:1px solid rgba(255,255,255,0.04);color:#CDAD69;vertical-align:top}
.badge{display:inline-block;font-size:10px;padding:2px 8px;border-radius:20px}
.badge-done{background:#085041;color:#9FE1CB}
.badge-pending{background:#412402;color:#FAC775}
.stat{text-align:center;padding:16px}
.stat-num{font-size:32px;font-weight:200;color:#F4E185;display:block}
.stat-label{font-size:11px;color:#89612B;letter-spacing:1px;text-transform:uppercase}
.back{display:inline-block;color:#89612B;text-decoration:none;font-size:12px;letter-spacing:1px;margin-bottom:30px;text-transform:uppercase}
.back:hover{color:#CDAD69}
</style>
</head>
<body>

<div class="topbar">
    <div>
        <div class="brand">LEGAiSEE</div>
        <div class="brand-sub">Memory Ingest Wing</div>
    </div>
    <div class="nav">
        <a href="/commandcenter/shell.php">← Grand Lobby</a>
    </div>
</div>

<div class="wrap">

    <a class="back" href="/commandcenter/shell.php">← Grand Lobby</a>

    <div class="page-title">Memory Ingest</div>
    <div class="page-sub">Sovereign Memory Intake — AI Session Archive</div>

    <!-- SUCCESS / ERROR -->
    <?php if ($message === 'success'): ?>
    <div class="success">✔ Session ingested successfully — ready for processing</div>
    <?php elseif (str_starts_with($message, 'error:')): ?>
    <div class="error-msg">✘ <?= htmlspecialchars(substr($message, 6)) ?></div>
    <?php endif; ?>

    <div class="grid-2">

        <!-- INGEST FORM -->
        <div class="card">
            <div class="card-title">Ingest New Session</div>
            <form method="POST">

                <div class="grid-2" style="gap:12px">
                    <div class="field">
                        <label>Memory Domain</label>
                        <select name="domain_id"><?= opts($domains) ?></select>
                    </div>
                    <div class="field">
                        <label>Project</label>
                        <select name="project_id"><?= opts($projects) ?></select>
                    </div>
                    <div class="field">
                        <label>AI Source</label>
                        <select name="source_ai">
                            <option>ChatGPT</option>
                            <option>Claude</option>
                            <option>Gemini</option>
                            <option>Grok</option>
                            <option>Cursor</option>
                            <option>Windsurf</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Session Title</label>
                        <input name="session_title" type="text" placeholder="e.g. Shell.php wing fixes">
                    </div>
                </div>

                <div class="field">
                    <label>Paste Full Transcript</label>
                    <textarea name="raw_transcript" placeholder="Paste the full AI conversation here..."></textarea>
                </div>

                <button class="btn" type="submit">INGEST SESSION</button>
            </form>
        </div>

        <!-- STATS + RECENT -->
        <div>
            <div class="card" style="margin-bottom:20px">
                <div class="card-title">Memory Bank</div>
                <div class="stat">
                    <span class="stat-num"><?= $total ?></span>
                    <span class="stat-label">Sessions Stored</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Recent Ingests</div>
                <?php if (empty($latest)): ?>
                <div style="color:#89612B;font-size:13px;padding:10px 0">No sessions yet — ingest your first one</div>
                <?php else: ?>
                <table>
                    <tr><th>Title</th><th>Source</th><th>Status</th></tr>
                    <?php foreach ($latest as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['session_title'] ?? 'Untitled') ?></td>
                        <td><?= htmlspecialchars($r['source_ai'] ?? '') ?></td>
                        <td>
                            <?php if ($r['processed']): ?>
                            <span class="badge badge-done">Processed</span>
                            <?php else: ?>
                            <span class="badge badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

</body>
</html>