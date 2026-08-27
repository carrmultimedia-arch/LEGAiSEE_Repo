<?php
// modules/governance_module.php
// LEGAiSEE Governance Command Center Module
// Reads _governance/ and _operations/ text files, renders operational UI

require_once __DIR__ . '/utils/bootstrap.php';

// ── CONFIG ───────────────────────────────────────────────────────────────────
$govPath      = __DIR__ . '/../_governance';
$opsPath      = __DIR__ . '/../_operations';
$generatedPath = __DIR__ . '/../_generated';

// ── AI PLATFORMS (Free Tier) ─────────────────────────────────────────────────
$aiPlatforms = [
    ['name' => 'Claude',      'url' => 'https://claude.ai',           'icon' => '🧠', 'class' => 'claude'],
    ['name' => 'ChatGPT',     'url' => 'https://chat.openai.com',     'icon' => '💬', 'class' => 'chatgpt'],
    ['name' => 'Gemini',      'url' => 'https://gemini.google.com',   'icon' => '♊', 'class' => 'gemini'],
    ['name' => 'Perplexity',  'url' => 'https://perplexity.ai',       'icon' => '🔍', 'class' => 'perplexity'],
    ['name' => 'HuggingChat', 'url' => 'https://huggingface.co/chat', 'icon' => '🤗', 'class' => 'hugging'],
    ['name' => 'Poe',         'url' => 'https://poe.com',             'icon' => '📱', 'class' => 'poe'],
    ['name' => 'Kimi',        'url' => 'https://kimi.moonshot.cn',    'icon' => '🌙', 'class' => 'kimi'],
];

// ── HELPERS ──────────────────────────────────────────────────────────────────

function gov_read_file(string $path): string {
    return file_exists($path) ? file_get_contents($path) : '[File not found: ' . basename($path) . ']';
}

function gov_read_tail(string $path, int $lines = 20): array {
    if (!file_exists($path)) return [];
    $all = file($path, FILE_IGNORE_NEW_LINES);
    return array_slice($all, -$lines);
}

function gov_list_txt_files(string $dir): array {
    if (!is_dir($dir)) return [];
    $files = [];
    foreach (glob($dir . '/*.txt') as $f) {
        $files[] = [
            'name' => basename($f),
            'size' => filesize($f),
            'mtime' => date('Y-m-d H:i', filemtime($f)),
        ];
    }
    usort($files, fn($a, $b) => $b['mtime'] <=> $a['mtime']);
    return $files;
}

function gov_parse_tasks(string $content): array {
    $tasks = [];
    $lines = explode("
", $content);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] !== '-') continue;
        $status = 'pending';
        if (str_starts_with($line, '- [x]')) $status = 'complete';
        elseif (str_starts_with($line, '- [~]')) $status = 'blocked';
        $text = preg_replace('/^- \[[x~ ]\] /', '', $line);
        $tasks[] = ['text' => $text, 'status' => $status, 'raw' => $line];
    }
    return $tasks;
}

// ── ACTION HANDLERS (POST) ───────────────────────────────────────────────────

$action = $_POST['action'] ?? '';
$message = '';

if ($action === 'save_today' && !empty($_POST['today_content'])) {
    $todayPath = $opsPath . '/daily/TODAY.txt';
    file_put_contents($todayPath, $_POST['today_content']);
    $message = 'TODAY.txt saved.';
}

if ($action === 'log_session' && !empty($_POST['wo_number'])) {
    $logPath = $opsPath . '/logs/SESSION_LOG.txt';
    $entry = "## " . date('Y-m-d') . " — WO-" . $_POST['wo_number'] . "
";
    $entry .= "Status: " . ($_POST['status'] ?? 'COMPLETE') . "
";
    $entry .= "Built: " . ($_POST['built'] ?? '') . "
";
    $entry .= "Files deployed: " . ($_POST['files'] ?? '') . "
";
    $entry .= "Blockers: " . ($_POST['blockers'] ?? 'None') . "
";
    $entry .= "Notes: " . ($_POST['notes'] ?? '') . "

";
    $existing = file_exists($logPath) ? file_get_contents($logPath) : '';
    file_put_contents($logPath, $entry . $existing);
    $message = 'Session logged.';
}

if ($action === 'move_file' && !empty($_POST['file']) && !empty($_POST['from']) && !empty($_POST['to'])) {
    $from = $generatedPath . '/' . $_POST['from'] . '/' . $_POST['file'];
    $to = $generatedPath . '/' . $_POST['to'] . '/' . $_POST['file'];
    if (file_exists($from)) {
        rename($from, $to);
        $message = 'Moved ' . $_POST['file'] . ' to ' . $_POST['to'] . '/';
    }
}

// ── DATA GATHERING ───────────────────────────────────────────────────────────

$priorities   = gov_read_file($opsPath . '/daily/PRIORITIES.txt');
$activeTasks  = gov_read_file($opsPath . '/tasks/ACTIVE_TASKS.txt');
$blockers     = gov_read_file($opsPath . '/tasks/BLOCKERS.txt');
$sessionLog   = gov_read_file($opsPath . '/logs/SESSION_LOG.txt');

$todayContent = gov_read_file($opsPath . '/daily/TODAY.txt');
$todayExists = file_exists($opsPath . '/daily/TODAY.txt');

$logEntries = [];
if (file_exists($opsPath . '/logs/SESSION_LOG.txt')) {
    $logRaw = file_get_contents($opsPath . '/logs/SESSION_LOG.txt');
    preg_match_all('/##\s+\d{4}-\d{2}-\d{2}\s+—\s+WO-[^
]+.*?(?=##\s+\d{4}-\d{2}-\d{2}|$)/s', $logRaw, $matches);
    $logEntries = array_slice($matches[0], 0, 10);
}

$reviewFiles = gov_list_txt_files($generatedPath . '/review');
$approvedFiles = gov_list_txt_files($generatedPath . '/approved');
$deployedFiles = gov_list_txt_files($generatedPath . '/deployed');

$govFiles = [];
if (is_dir($govPath)) {
    foreach (glob($govPath . '/*.txt') as $f) {
        $govFiles[] = ['name' => basename($f), 'mtime' => date('Y-m-d H:i', filemtime($f))];
    }
}

$health = [];
$urls = [
    'Grand Lobby' => 'https://legaisee.com/commandcenter/shell.php',
    'Dashboard' => 'https://legaisee.com/commandcenter/shell.php?module=dashboard',
    'Brain' => 'https://legaisee.com/commandcenter/shell.php?module=brain',
];
foreach ($urls as $name => $url) {
    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
    $content = @file_get_contents($url, false, $ctx);
    $hasError = $content === false || str_contains($content, 'Fatal error') || str_contains($content, 'Parse error');
    $health[$name] = [
        'status' => $hasError ? 'error' : 'ok',
        'response' => $content === false ? 'Unreachable' : ($hasError ? 'PHP Error detected' : '200 OK')
    ];
}

// ── MORNING BRIEF PROMPT ASSEMBLY ────────────────────────────────────────────

$morningPrompt = "Good morning. Read these and produce TODAY.txt (the work order):

";
$morningPrompt .= "=== PRIORITIES ===
" . $priorities . "

";
$morningPrompt .= "=== ACTIVE TASKS ===
" . $activeTasks . "

";
$morningPrompt .= "=== BLOCKERS ===
" . $blockers . "

";
$morningPrompt .= "=== SESSION LOG (last 5 entries) ===
";
$lastLogLines = gov_read_tail($opsPath . '/logs/SESSION_LOG.txt', 20);
$morningPrompt .= implode("
", $lastLogLines) . "

";
$morningPrompt .= "Produce TODAY.txt with:
- Date and WO number
- Priority ordered task list
- Estimated time per task
- Any blockers to resolve first
- End of day target";

// ── RENDER ───────────────────────────────────────────────────────────────────

$html = '';

if ($message) {
    $html .= "<div class='gov-toast'>" . htmlspecialchars($message) . "</div>";
}

// ── AI LAUNCHER BAR ──
$html .= "<div class='ai-launcher-bar'>";
$html .= "<span class='ai-launcher-label'>Launch AI</span>";
foreach ($aiPlatforms as $plat) {
    $html .= "<a href='" . htmlspecialchars($plat['url']) . "' target='_blank' class='ai-launcher-btn " . $plat['class'] . "'>";
    $html .= "<span class='icon'>" . $plat['icon'] . "</span>";
    $html .= htmlspecialchars($plat['name']);
    $html .= "</a>";
}
$html .= "</div>";

$html .= "<div class='gov-tabs'>";
$html .= "<button class='gov-tab active' onclick='gov_switchTab(\"brief\")'>Morning Brief</button>";
$html .= "<button class='gov-tab' onclick='gov_switchTab(\"queue\")'>Work Order Queue</button>";
$html .= "<button class='gov-tab' onclick='gov_switchTab(\"log\")'>Session Log</button>";
$html .= "<button class='gov-tab' onclick='gov_switchTab(\"pipeline\")'>Build Pipeline</button>";
$html .= "<button class='gov-tab' onclick='gov_switchTab(\"health\")'>Health Monitor</button>";
$html .= "<button class='gov-tab' onclick='gov_switchTab(\"governance\")'>Governance Files</button>";
$html .= "</div>";

// ── TAB 1: MORNING BRIEF ──
$html .= "<div id='tab-brief' class='gov-panel active'>";
$html .= "<div class='gov-section'>";
$html .= "<h2>Morning Brief Generator</h2>";
$html .= "<p>Copy this prompt into Claude. Paste the response below and save.</p>";
$html .= "<div class='gov-prompt-box'>";
$html .= "<pre id='morning-prompt'>" . htmlspecialchars($morningPrompt) . "</pre>";
$html .= "<button class='gov-btn' onclick='gov_copyPrompt()'>📋 Copy Prompt</button>";
$html .= "</div>";
$html .= "</div>";

$html .= "<div class='gov-section'>";
$html .= "<h3>TODAY.txt " . ($todayExists ? '<span class="gov-badge">Exists</span>' : '<span class="gov-badge warn">Not created</span>') . "</h3>";
$html .= "<form method='post'>";
$html .= "<input type='hidden' name='action' value='save_today'>";
$html .= "<textarea name='today_content' class='gov-textarea' rows='20'>" . htmlspecialchars($todayContent) . "</textarea>";
$html .= "<button type='submit' class='gov-btn primary'>💾 Save TODAY.txt</button>";
$html .= "</form>";
$html .= "</div>";
$html .= "</div>";

// ── TAB 2: WORK ORDER QUEUE ──
$html .= "<div id='tab-queue' class='gov-panel'>";
$html .= "<div class='gov-section'>";
$html .= "<h2>Work Order Queue</h2>";
if ($todayExists) {
    $tasks = gov_parse_tasks($todayContent);
    if (empty($tasks)) {
        $html .= "<p class='gov-empty'>No tasks found in TODAY.txt. Check format (lines must start with '- [ ]').</p>";
    } else {
        $html .= "<div class='gov-task-grid'>";
        foreach ($tasks as $i => $task) {
            $statusClass = $task['status'] === 'complete' ? 'complete' : ($task['status'] === 'blocked' ? 'blocked' : '');
            $html .= "<div class='gov-task-card " . $statusClass . "'>";
            $html .= "<div class='gov-task-num'>" . ($i + 1) . "</div>";
            $html .= "<div class='gov-task-text'>" . htmlspecialchars($task['text']) . "</div>";
            $html .= "<div class='gov-task-status'>" . strtoupper($task['status']) . "</div>";
            $html .= "</div>";
        }
        $html .= "</div>";
    }
} else {
    $html .= "<p class='gov-empty'>No TODAY.txt found. Generate it in Morning Brief first.</p>";
}
$html .= "</div>";
$html .= "</div>";

// ── TAB 3: SESSION LOG ──
$html .= "<div id='tab-log' class='gov-panel'>";
$html .= "<div class='gov-section'>";
$html .= "<h2>Recent Session Log Entries</h2>";
if (empty($logEntries)) {
    $html .= "<p class='gov-empty'>No log entries found.</p>";
} else {
    foreach ($logEntries as $entry) {
        $html .= "<div class='gov-log-entry'><pre>" . htmlspecialchars($entry) . "</pre></div>";
    }
}
$html .= "</div>";

$html .= "<div class='gov-section'>";
$html .= "<h3>Log New Deployment</h3>";
$html .= "<form method='post'>";
$html .= "<input type='hidden' name='action' value='log_session'>";
$html .= "<div class='gov-form-row'><label>WO Number</label><input type='text' name='wo_number' placeholder='001' required></div>";
$html .= "<div class='gov-form-row'><label>Status</label><select name='status'><option>COMPLETE</option><option>PARTIAL</option><option>FAILED</option></select></div>";
$html .= "<div class='gov-form-row'><label>What Was Built</label><input type='text' name='built' placeholder='governance module v1'></div>";
$html .= "<div class='gov-form-row'><label>Files Deployed</label><input type='text' name='files' placeholder='modules/governance_module.php, ui/global.css'></div>";
$html .= "<div class='gov-form-row'><label>Blockers</label><input type='text' name='blockers' placeholder='None'></div>";
$html .= "<div class='gov-form-row'><label>Notes for Claude</label><textarea name='notes' rows='3'></textarea></div>";
$html .= "<button type='submit' class='gov-btn primary'>📝 Log Session</button>";
$html .= "</form>";
$html .= "</div>";
$html .= "</div>";

// ── TAB 4: BUILD PIPELINE ──
$html .= "<div id='tab-pipeline' class='gov-panel'>";
foreach (['review' => 'Review', 'approved' => 'Approved', 'deployed' => 'Deployed'] as $stage => $label) {
    $files = ${$stage . 'Files'};
    $html .= "<div class='gov-section'>";
    $html .= "<h3>" . $label . " <span class='gov-count'>(" . count($files) . ")</span></h3>";
    if (empty($files)) {
        $html .= "<p class='gov-empty'>No files in " . $stage . "/</p>";
    } else {
        $html .= "<div class='gov-file-list'>";
        foreach ($files as $f) {
            $html .= "<div class='gov-file-row'>";
            $html .= "<span class='gov-file-name'>" . htmlspecialchars($f['name']) . "</span>";
            $html .= "<span class='gov-file-meta'>" . $f['size'] . " bytes · " . $f['mtime'] . "</span>";
            if ($stage === 'review') {
                $html .= "<form method='post' class='gov-inline'>";
                $html .= "<input type='hidden' name='action' value='move_file'>";
                $html .= "<input type='hidden' name='file' value='" . htmlspecialchars($f['name']) . "'>";
                $html .= "<input type='hidden' name='from' value='review'>";
                $html .= "<input type='hidden' name='to' value='approved'>";
                $html .= "<button type='submit' class='gov-btn small'>✓ Approve</button>";
                $html .= "</form>";
            } elseif ($stage === 'approved') {
                $html .= "<form method='post' class='gov-inline'>";
                $html .= "<input type='hidden' name='action' value='move_file'>";
                $html .= "<input type='hidden' name='file' value='" . htmlspecialchars($f['name']) . "'>";
                $html .= "<input type='hidden' name='from' value='approved'>";
                $html .= "<input type='hidden' name='to' value='deployed'>";
                $html .= "<button type='submit' class='gov-btn small primary'>🚀 Deploy</button>";
                $html .= "</form>";
            }
            $html .= "</div>";
        }
        $html .= "</div>";
    }
    $html .= "</div>";
}
$html .= "</div>";

// ── TAB 5: HEALTH MONITOR ──
$html .= "<div id='tab-health' class='gov-panel'>";
$html .= "<div class='gov-section'>";
$html .= "<h2>System Health</h2>";
$html .= "<div class='gov-health-grid'>";
foreach ($health as $name => $check) {
    $icon = $check['status'] === 'ok' ? '🟢' : '🔴';
    $class = $check['status'] === 'ok' ? 'ok' : 'error';
    $html .= "<div class='gov-health-card " . $class . "'>";
    $html .= "<div class='gov-health-icon'>" . $icon . "</div>";
    $html .= "<div class='gov-health-name'>" . htmlspecialchars($name) . "</div>";
    $html .= "<div class='gov-health-status'>" . htmlspecialchars($check['response']) . "</div>";
    $html .= "</div>";
}
$html .= "</div>";
$html .= "<button class='gov-btn' onclick='location.reload()'>🔄 Refresh Check</button>";
$html .= "</div>";
$html .= "</div>";

// ── TAB 6: GOVERNANCE FILES ──
$html .= "<div id='tab-governance' class='gov-panel'>";
$html .= "<div class='gov-section'>";
$html .= "<h2>Governance Files (25)</h2>";
$html .= "<div class='gov-gov-list'>";
foreach ($govFiles as $i => $gf) {
    $html .= "<div class='gov-gov-card'>";
    $html .= "<span class='num'>" . sprintf('%02d', $i) . "</span>";
    $html .= "<span class='name'>" . htmlspecialchars($gf['name']) . "</span>";
    $html .= "<span class='mtime'>" . $gf['mtime'] . "</span>";
    $html .= "</div>";
}
$html .= "</div>";
$html .= "</div>";
$html .= "</div>";

// ── JAVASCRIPT ──
$html .= "<script>
function gov_switchTab(tabId) {
    document.querySelectorAll('.gov-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.gov-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + tabId).classList.add('active');
    event.target.classList.add('active');
}
function gov_copyPrompt() {
    const text = document.getElementById('morning-prompt').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Prompt copied. Paste into Claude, then paste response back here.');
    });
}
</script>";

return $html;