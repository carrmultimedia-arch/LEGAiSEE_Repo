<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/kernel/kernel_boot.php';
require_once __DIR__ . '/engine/entity_extraction_engine.php';

$dossier      = null;
$error        = null;
$ingestRecord = null;   // the newly written ingest row
$ingestHistory = [];    // all ingests for this prospect, newest first

// ── ENSURE INGEST TABLE EXISTS ──────────────────────────────────────────────
function ensure_ingest_table(\PDO $db): void
{
    $db->exec("
        CREATE TABLE IF NOT EXISTS prospect_ingests (
            id              INT AUTO_INCREMENT PRIMARY KEY,
            prospect_key    VARCHAR(255) NOT NULL,
            prospect_name   VARCHAR(255) NOT NULL,
            ingest_number   INT          NOT NULL,
            dossier_id      VARCHAR(255),
            authority_score TINYINT UNSIGNED DEFAULT 0,
            signal_count    TINYINT UNSIGNED DEFAULT 0,
            status          ENUM('current','archived') NOT NULL DEFAULT 'current',
            created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_key_status (prospect_key, status),
            INDEX idx_prospect_key (prospect_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
}

// ── NORMALISE PROSPECT KEY ───────────────────────────────────────────────────
function prospect_key(string $name): string
{
    return strtolower(preg_replace('/[^a-z0-9]+/i', '_', trim($name)));
}

// ── GET ALL INGESTS FOR A PROSPECT ───────────────────────────────────────────
function get_ingest_history(\PDO $db, string $key): array
{
    $stmt = $db->prepare("
        SELECT id, ingest_number, authority_score, signal_count,
               status, created_at, dossier_id
        FROM   prospect_ingests
        WHERE  prospect_key = :key
        ORDER  BY ingest_number DESC
    ");
    $stmt->execute([':key' => $key]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

// ── WRITE A NEW INGEST, ARCHIVE PREVIOUS ─────────────────────────────────────
function write_ingest(
    \PDO   $db,
    string $key,
    string $name,
    string $dossierId,
    int    $score,
    int    $signalCount
): array {
    // archive every existing current row for this prospect
    $db->prepare("
        UPDATE prospect_ingests
        SET    status = 'archived'
        WHERE  prospect_key = :key AND status = 'current'
    ")->execute([':key' => $key]);

    // next ingest number
    $stmt = $db->prepare("
        SELECT COALESCE(MAX(ingest_number), 0) + 1
        FROM   prospect_ingests
        WHERE  prospect_key = :key
    ");
    $stmt->execute([':key' => $key]);
    $nextNum = (int) $stmt->fetchColumn();

    // insert the new current row
    $ins = $db->prepare("
        INSERT INTO prospect_ingests
            (prospect_key, prospect_name, ingest_number,
             dossier_id, authority_score, signal_count, status)
        VALUES
            (:key, :name, :num, :did, :score, :sigs, 'current')
    ");
    $ins->execute([
        ':key'   => $key,
        ':name'  => $name,
        ':num'   => $nextNum,
        ':did'   => $dossierId,
        ':score' => $score,
        ':sigs'  => $signalCount,
    ]);

    return [
        'ingest_number' => $nextNum,
        'created_at'    => date('c'),
        'status'        => 'current',
    ];
}

// ─────────────────────────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prospectName = trim($_POST['prospect_name'] ?? '');
    $rawInput     = trim($_POST['raw_input']     ?? '');

    if (!$prospectName || !$rawInput) {
        $error = 'Please enter a prospect name and paste some content.';
    } else {

     // --- SIGNAL EXTRACTION (confidence-weighted) ---
$signalMap = [
    'ops_delay'        => ['keywords' => ['delay','late','slow','backlog','behind','bottleneck','wait','overdue','reschedule'],    'label' => 'Operational Delays',      'priority' => 'HIGH'],
    'pricing_pressure' => ['keywords' => ['price','cost','expensive','cheap','budget','afford','rate','overpriced','quote','bid'], 'label' => 'Pricing Friction',         'priority' => 'HIGH'],
    'lead_friction'    => ['keywords' => ['lead','conversion','funnel','prospect','inquiry','traffic','referral','close','sales'], 'label' => 'Lead/Conversion Weakness', 'priority' => 'HIGH'],
    'labor_issue'      => ['keywords' => ['staff','employee','hire','turnover','team','understaffed','labor','crew','shortage'],   'label' => 'Workforce Strain',         'priority' => 'MEDIUM'],
    'brand_gap'        => ['keywords' => ['brand','reputation','trust','credibility','authority','known','visibility','image'],    'label' => 'Authority/Brand Gap',     'priority' => 'HIGH'],
    'growth_signal'    => ['keywords' => ['grow','expand','scale','launch','new','opening','adding','increasing','ambitious'],     'label' => 'Growth Signal',            'priority' => 'MEDIUM'],
    'market_shift'     => ['keywords' => ['competition','competitor','market','industry','trend','shift','changing','pressure'],   'label' => 'Market Shift Detected',   'priority' => 'MEDIUM'],
    'tech_gap'         => ['keywords' => ['website','online','digital','social','seo','google','review','presence','listing'],    'label' => 'Digital/Tech Gap',        'priority' => 'MEDIUM'],
];

$textLower       = strtolower($rawInput);
$wordCount       = str_word_count($textLower);
$detectedSignals = [];

foreach ($signalMap as $key => $def) {
    $hits = 0;
    foreach ($def['keywords'] as $kw) {
        // Count occurrences, not just presence
        $hits += substr_count($textLower, $kw);
    }
    // Require at least 2 keyword hits to trigger a signal
    if ($hits >= 2) {
        // Confidence: how densely evidenced is this signal?
        $confidence = min(1.0, $hits / 6); // 6+ hits = full confidence
        $detectedSignals[$key] = array_merge($def, ['confidence' => $confidence, 'hits' => $hits]);
    }
}
// --- ENTITY EXTRACTION ---
$db         = kernel_db();
$entityData = $db ? lee_extract_and_store($db, $rawInput, 'prospect', $prospectName, $prospectName) : null;
// --- AUTHORITY SCORE ---
// Base: 30 (weak prospect with thin content)
// Each HIGH signal: up to 14 pts scaled by confidence
// Each MEDIUM signal: up to 7 pts scaled by confidence
// Content depth bonus: up to 8 pts for rich input
// Max realistic score: ~88-92. Reserve 93+ for exceptional cases.

$score     = 30;
$highCount = 0;

foreach ($detectedSignals as $sig) {
    $conf = $sig['confidence'];
    if ($sig['priority'] === 'HIGH') {
        $score += (int) round(14 * $conf);
        $highCount++;
    } else {
        $score += (int) round(7 * $conf);
    }
}

// Content depth bonus — longer, richer input = slightly higher confidence
if ($wordCount > 800)       $score += 8;
elseif ($wordCount > 400)   $score += 5;
elseif ($wordCount > 150)   $score += 2;

// Signal count bonus — many signals = clearly a troubled/opportunity-rich business
$sigCount = count($detectedSignals);
if ($sigCount >= 7)         $score += 6;
elseif ($sigCount >= 5)     $score += 3;

$score            = max(28, min(96, $score));
$opportunityLevel = $score >= 75 ? 'STRONG' : ($score >= 52 ? 'MODERATE' : 'LOW');

        // --- NARRATIVE / ACTION MAPS ---
        $narrativeMap = [
            'ops_delay'        => 'Operational friction signals suggest delivery or workflow inefficiencies that are likely costing this business in reputation and repeat clients.',
            'pricing_pressure' => 'Pricing signals indicate a gap between perceived value and market expectation — a core authority problem LEGAiSEE is built to solve.',
            'lead_friction'    => 'Lead generation or conversion weakness detected. This business may be losing prospects at the awareness or trust stage.',
            'labor_issue'      => 'Workforce strain signals suggest internal execution inconsistency that may be affecting client experience and delivery quality.',
            'brand_gap'        => 'Authority and brand credibility gaps are present. This is a direct LEGAiSEE intervention point — positioning and trust reconstruction.',
            'growth_signal'    => 'Active growth intent detected. This prospect is in motion and may be receptive to systems that help them scale with authority.',
            'market_shift'     => 'Market or competitive pressure signals detected. This business may be reacting to industry changes without a strategic authority anchor.',
            'tech_gap'         => 'Digital presence gaps detected. Online authority and discoverability may be underperforming relative to business potential.',
        ];

        $actionMap = [
            'ops_delay'        => 'Conduct Operational Archaeology — recover past workflow decisions and reconstruct a delivery authority narrative.',
            'pricing_pressure' => 'Build a Value Authority Dossier — reposition pricing through documented expertise and outcome evidence.',
            'lead_friction'    => 'Deploy Authority Funnel Reconstruction — align messaging to trust signals at each conversion stage.',
            'labor_issue'      => 'Internal Authority Audit — assess how team consistency (or lack of) is perceived by clients.',
            'brand_gap'        => 'Full Business Archaeology engagement — reconstruct brand authority from historical assets.',
            'growth_signal'    => 'Authority Scaling Assessment — ensure growth is anchored in credibility, not just volume.',
            'market_shift'     => 'Competitive Authority Mapping — identify where this business can own a defensible authority position.',
            'tech_gap'         => 'Digital Authority Audit — assess online presence gaps and build a discoverability roadmap.',
        ];

        // --- BUILD DOSSIER ID ---
        $dossierId = 'prospect_' . preg_replace('/[^a-z0-9]/', '_', strtolower($prospectName)) . '_' . time();

        // --- INGEST COUNTER ---
        $pKey = prospect_key($prospectName);
        if ($db) {
            ensure_ingest_table($db);
            $ingestRecord  = write_ingest($db, $pKey, $prospectName, $dossierId, $score, count($detectedSignals));
            $ingestHistory = get_ingest_history($db, $pKey);
        }

        // --- SAVE TO JSON ---
        $dossierData = [
            'id'                => $dossierId,
            'prospect_name'     => $prospectName,
            'created_at'        => date('c'),
            'ingest_number'     => $ingestRecord['ingest_number'] ?? 1,
            'raw_input_length'  => strlen($rawInput),
            'signals'           => $detectedSignals,
            'authority_score'   => $score,
            'opportunity_level' => $opportunityLevel,
            'entity_data'       => $entityData,
        ];

        $saveDir = __DIR__ . '/data/prospects/';
        if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);
        file_put_contents($saveDir . $dossierId . '.json', json_encode($dossierData, JSON_PRETTY_PRINT));

        $dossier = [
            'name'          => $prospectName,
            'score'         => $score,
            'level'         => $opportunityLevel,
            'signals'       => $detectedSignals,
            'narrativeMap'  => $narrativeMap,
            'actionMap'     => $actionMap,
            'entityData'    => $entityData,
            'highCount'     => $highCount,
            'ingestNumber'  => $ingestRecord['ingest_number'] ?? 1,
            'ingestHistory' => $ingestHistory,
        ];
    }
}

// ── HELPER: format timestamp for display ─────────────────────────────────────
function fmt_ts(string $ts): string
{
    try {
        $dt = new DateTimeImmutable($ts);
        return $dt->format('M j · g:i a');
    } catch (\Throwable) {
        return $ts;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE — Prospect Excavation</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
html,body{width:100%;min-height:100%;overflow-x:hidden}
body{font-family:Inter,system-ui,sans-serif;color:#CDAD69;
background:linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.88)),
url('/commandcenter/ui/images/dark-room-with-black-wall-black-wall-with-carved-design_902639-63079-upscale-4x.jpg');
background-size:cover;background-position:center;background-attachment:fixed}
*::-webkit-scrollbar{width:6px}
*::-webkit-scrollbar-thumb{background:linear-gradient(#e6c256,#ce9008,#e7ca5d);border-radius:999px}

/* ── TOPBAR ── */
.topbar{position:sticky;top:0;z-index:100;width:100%;height:88px;display:flex;align-items:center;
justify-content:space-between;padding:0 50px;backdrop-filter:blur(18px);
background:linear-gradient(rgba(10,10,10,0.60),rgba(10,10,10,0.35));
border-bottom:1px solid rgba(255,255,255,0.05);box-shadow:0 10px 40px rgba(0,0,0,0.55)}
.brand-title{font-size:18px;letter-spacing:4px;color:#F4E185;font-weight:300}
.brand-sub{font-size:11px;letter-spacing:2px;color:#89612B;text-transform:uppercase;margin-top:4px}
.nav{display:flex;gap:10px}
.nav a{text-decoration:none;color:#CDAD69;padding:8px 14px;border-radius:999px;
background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);font-size:12px;transition:0.3s}
.nav a:hover{color:#F4E185;border-color:rgba(230,194,86,0.35);transform:translateY(-2px)}

/* ── LAYOUT ── */
.wrap{max-width:960px;margin:auto;padding:60px 30px 120px}
.page-label{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:#89612B;margin-bottom:16px}
.page-title{font-size:52px;font-weight:200;color:#F4E185;margin-bottom:16px;line-height:1}
.page-sub{color:#AC8B56;font-size:16px;line-height:1.7;margin-bottom:50px;max-width:680px}
.card{background:linear-gradient(180deg,rgba(24,24,26,0.90),rgba(10,10,12,0.82));
backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,0.05);border-radius:24px;
padding:36px;margin-bottom:30px;box-shadow:0 30px 80px rgba(0,0,0,0.60)}
.field-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#89612B;margin-bottom:10px;display:block}
input[type=text]{width:100%;padding:14px 18px;border-radius:12px;
border:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.40);
color:#F4E185;font-size:16px;font-family:inherit;margin-bottom:24px;outline:none;transition:0.3s}
input[type=text]:focus{border-color:rgba(230,194,86,0.40);background:rgba(0,0,0,0.55)}
textarea{width:100%;padding:14px 18px;border-radius:12px;
border:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.40);
color:#CDAD69;font-size:14px;font-family:inherit;line-height:1.7;resize:vertical;
min-height:240px;outline:none;transition:0.3s}
textarea:focus{border-color:rgba(230,194,86,0.40);background:rgba(0,0,0,0.55)}
textarea::placeholder{color:#4a3a1a}
.btn{display:inline-block;padding:14px 36px;border-radius:999px;border:none;cursor:pointer;
font-size:14px;font-family:inherit;letter-spacing:1px;font-weight:500;transition:0.3s;
background:linear-gradient(135deg,#e6c256,#ce9008);color:#0a0a0c}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(230,194,86,0.30)}
.error-box{background:rgba(255,80,80,0.08);border:1px solid rgba(255,80,80,0.20);
border-radius:12px;padding:16px 20px;color:#ff9090;font-size:14px;margin-bottom:24px}

/* ── INGEST COUNTER STRIP ── */
.ingest-strip{
    display:flex;
    align-items:center;
    gap:0;
    margin-bottom:28px;
    overflow-x:auto;
    padding-bottom:4px;
    -ms-overflow-style:none;
    scrollbar-width:none;
}
.ingest-strip::-webkit-scrollbar{display:none}

.ingest-strip-label{
    font-size:10px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#4a3a1a;
    white-space:nowrap;
    margin-right:16px;
    flex-shrink:0;
}

/* connector line between pills */
.ingest-connector{
    width:24px;
    height:1px;
    background:rgba(255,255,255,0.06);
    flex-shrink:0;
}

/* base pill */
.ingest-pill{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:4px;
    flex-shrink:0;
    position:relative;
}

.ingest-pill-badge{
    width:36px;
    height:36px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    font-weight:500;
    border:1.5px solid;
    transition:all 0.2s;
    position:relative;
}

.ingest-pill-meta{
    font-size:10px;
    letter-spacing:0.5px;
    text-align:center;
    line-height:1.4;
    white-space:nowrap;
}

/* archived (greyed out) */
.ingest-pill.archived .ingest-pill-badge{
    background:rgba(255,255,255,0.02);
    border-color:rgba(255,255,255,0.06);
    color:rgba(255,255,255,0.15);
}
.ingest-pill.archived .ingest-pill-meta{
    color:rgba(255,255,255,0.12);
}
.ingest-pill.archived .ingest-pill-score{
    color:rgba(255,255,255,0.10);
}

/* current (active, gold) */
.ingest-pill.current .ingest-pill-badge{
    background:linear-gradient(135deg,rgba(230,194,86,0.15),rgba(206,144,8,0.08));
    border-color:rgba(230,194,86,0.55);
    color:#F4E185;
    box-shadow:0 0 16px rgba(230,194,86,0.18);
}
.ingest-pill.current .ingest-pill-badge::after{
    content:'';
    position:absolute;
    inset:-4px;
    border-radius:50%;
    border:1px solid rgba(230,194,86,0.20);
    animation:pulse-ring 2.5s ease-out infinite;
}
@keyframes pulse-ring{
    0%{opacity:0.8;transform:scale(1)}
    100%{opacity:0;transform:scale(1.5)}
}
.ingest-pill.current .ingest-pill-meta{
    color:#AC8B56;
}
.ingest-pill.current .ingest-pill-score{
    color:#e6c256;
    font-weight:500;
}

.ingest-pill-score{
    font-size:9px;
    letter-spacing:0.5px;
}

/* tooltip on hover for archived pills */
.ingest-pill.archived{cursor:default}
.ingest-pill[title]{cursor:default}

/* ── DOSSIER OUTPUT ── */
.dossier{margin-top:50px}
.dossier-header{border-radius:24px;padding:44px;margin-bottom:30px;
background:linear-gradient(135deg,rgba(30,24,8,0.95),rgba(10,10,12,0.92));
border:1px solid rgba(230,194,86,0.20);box-shadow:0 0 60px rgba(230,194,86,0.06)}
.dossier-label{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:#89612B;margin-bottom:12px}
.dossier-name{font-size:44px;font-weight:200;color:#F4E185;margin-bottom:24px}
.score-row{display:flex;align-items:center;gap:24px;flex-wrap:wrap}
.score-ring{width:90px;height:90px;border-radius:50%;
background:conic-gradient(#e6c256 <?php if($dossier): echo $dossier['score'] * 3.6; endif; ?>deg, rgba(255,255,255,0.05) 0deg);
display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative}
.score-inner{width:70px;height:70px;border-radius:50%;background:#0a0a0c;
display:flex;align-items:center;justify-content:center;flex-direction:column}
.score-num{font-size:22px;font-weight:300;color:#F4E185}
.score-pct{font-size:9px;color:#89612B;letter-spacing:1px}
.score-meta{flex:1}
.score-level{font-size:28px;font-weight:200;color:#F4E185;margin-bottom:6px}
.score-desc{font-size:14px;color:#AC8B56;line-height:1.6}
.signals-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-bottom:30px}
.signal-card{background:linear-gradient(180deg,rgba(24,24,26,0.90),rgba(10,10,12,0.82));
border:1px solid rgba(255,255,255,0.05);border-radius:16px;padding:22px}
.signal-priority{font-size:10px;letter-spacing:2px;color:#89612B;margin-bottom:8px}
.signal-priority.high{color:#e6c256}
.signal-label{font-size:16px;color:#F4E185;font-weight:300;margin-bottom:10px}
.signal-narrative{font-size:13px;color:#AC8B56;line-height:1.7;margin-bottom:14px}
.signal-action{font-size:12px;color:#CDAD69;background:rgba(255,255,255,0.03);
border:1px solid rgba(255,255,255,0.05);border-radius:8px;padding:10px 12px;line-height:1.6}
.section-title{font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#89612B;margin-bottom:16px}
.no-signals{color:#AC8B56;font-size:15px;font-style:italic;padding:20px 0}
.entity-row{display:flex;justify-content:space-between;padding:10px 14px;
border-radius:10px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.03);
margin-bottom:8px;font-size:13px}
.back-link{display:inline-block;margin-top:30px;color:#89612B;font-size:13px;
text-decoration:none;letter-spacing:1px}
.back-link:hover{color:#F4E185}

/* ingest badge inside dossier label row */
.ingest-badge-inline{
    display:inline-flex;
    align-items:center;
    gap:7px;
    background:rgba(230,194,86,0.08);
    border:1px solid rgba(230,194,86,0.25);
    border-radius:999px;
    padding:3px 12px 3px 8px;
    font-size:11px;
    color:#e6c256;
    letter-spacing:1px;
    margin-left:14px;
    vertical-align:middle;
    position:relative;
    top:-1px;
}
.ingest-badge-inline .dot{
    width:6px;height:6px;border-radius:50%;
    background:#e6c256;
    box-shadow:0 0 6px rgba(230,194,86,0.7);
    animation:blink 2s ease-in-out infinite;
}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.3}}

@media print{
    .topbar,.btn,form,.back-link,.ingest-strip{display:none}
    body{background:#fff;color:#000}
    .dossier-name,.score-level,.signal-label{color:#000}
    .signal-narrative,.score-desc{color:#333}
    .card,.dossier-header,.signal-card{border:1px solid #ccc;box-shadow:none}
}
</style>
</head>
<body>

<div class="topbar">
    <div>
        <div class="brand-title">LEGAiSEE</div>
        <div class="brand-sub">Business Archaeology Operating System</div>
    </div>
    <nav class="nav">
        <a href="/commandcenter/shell.php">← Lobby</a>
        <a href="/commandcenter/prospect.php">New Dig</a>
    </nav>
</div>

<div class="wrap">

<?php if (!$dossier): ?>

    <div class="page-label">Prospect Excavation</div>
    <h1 class="page-title">Shallow Dig</h1>
    <p class="page-sub">Paste anything — website copy, social posts, old ads, notes, reviews, emails. The system will extract signals and produce an Authority Dossier.</p>

    <?php if ($error): ?>
        <div class="error-box"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="POST" action="/commandcenter/prospect.php">
            <label class="field-label">Prospect / Business Name</label>
            <input type="text" name="prospect_name" placeholder="e.g. Hartmann Plumbing Co." value="<?= htmlspecialchars($_POST['prospect_name'] ?? '') ?>">

            <label class="field-label">Paste Anything You Have On Them</label>
            <textarea name="raw_input" placeholder="Paste website copy, LinkedIn bio, Google reviews, old ads, your notes — anything. The more the better but even a paragraph works."><?= htmlspecialchars($_POST['raw_input'] ?? '') ?></textarea>

            <button type="submit" class="btn">Run Excavation →</button>
        </form>
    </div>

<?php else: ?>

    <div class="dossier">

        <!-- ── INGEST COUNTER STRIP ── -->
        <?php if (!empty($dossier['ingestHistory'])): ?>
        <div class="ingest-strip">
            <span class="ingest-strip-label">Ingest History</span>

            <?php
            // history comes newest-first; reverse to display oldest→newest left→right
            $history     = array_reverse($dossier['ingestHistory']);
            $totalIngests = count($history);
            foreach ($history as $idx => $row):
                $isCurrent = ($row['status'] === 'current');
                $pillClass = $isCurrent ? 'current' : 'archived';
                $num       = (int) $row['ingest_number'];
                $ts        = fmt_ts($row['created_at']);
                $score     = (int) $row['authority_score'];
                $tooltip   = $isCurrent ? '' : "Ingest {$num} · {$ts} · Score {$score}";
            ?>
                <?php if ($idx > 0): ?>
                    <div class="ingest-connector"></div>
                <?php endif; ?>

                <div class="ingest-pill <?= $pillClass ?>"
                     <?= $tooltip ? 'title="' . htmlspecialchars($tooltip) . '"' : '' ?>>

                    <div class="ingest-pill-badge"><?= $num ?></div>

                    <div class="ingest-pill-meta">
                        <?= $isCurrent ? '<strong style="color:#e6c256;font-size:9px;letter-spacing:1px">CURRENT</strong>' : htmlspecialchars(date('M j', strtotime($row['created_at']))) ?>
                    </div>

                    <div class="ingest-pill-score">
                        <?= $isCurrent
                            ? htmlspecialchars($ts)
                            : 'Score ' . $score ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- ── DOSSIER HEADER / SCORE ── -->
        <div class="dossier-header">
            <div class="dossier-label">
                Authority Dossier — Shallow Dig
                <span class="ingest-badge-inline">
                    <span class="dot"></span>
                    Ingest <?= $dossier['ingestNumber'] ?>
                </span>
            </div>
            <div class="dossier-name"><?= htmlspecialchars($dossier['name']) ?></div>
            <div class="score-row">
                <div class="score-ring">
                    <div class="score-inner">
                        <div class="score-num"><?= $dossier['score'] ?></div>
                        <div class="score-pct">SCORE</div>
                    </div>
                </div>
                <div class="score-meta">
                    <div class="score-level">
                        <?= $dossier['level'] ?> OPPORTUNITY
                    </div>
                    <div class="score-desc">
                        <?= $dossier['highCount'] ?> high-priority signal<?= $dossier['highCount'] !== 1 ? 's' : '' ?> detected.
                        <?php if ($dossier['level'] === 'STRONG'): ?>
                            This prospect has significant authority gaps LEGAiSEE can address.
                        <?php elseif ($dossier['level'] === 'MODERATE'): ?>
                            Meaningful signals present — worth a deeper dig.
                        <?php else: ?>
                            Limited signals in the pasted content — try adding more material.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SIGNALS ── -->
        <div class="card">
            <div class="section-title">Detected Signals</div>
            <?php if (empty($dossier['signals'])): ?>
                <div class="no-signals">No strong signals detected. Try pasting more content — website copy, reviews, or social posts work best.</div>
            <?php else: ?>
                <div class="signals-grid">
                <?php foreach ($dossier['signals'] as $key => $sig): ?>
                    <div class="signal-card">
                        <div class="signal-priority <?= strtolower($sig['priority']) ?>"><?= $sig['priority'] ?> PRIORITY</div>
                        <div class="signal-label"><?= htmlspecialchars($sig['label']) ?></div>
                        <div class="signal-narrative"><?= htmlspecialchars($dossier['narrativeMap'][$key] ?? '') ?></div>
                        <div class="signal-action">→ <?= htmlspecialchars($dossier['actionMap'][$key] ?? '') ?></div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── ENTITIES ── -->
        <?php if ($dossier['entityData'] && $dossier['entityData']['entities_stored'] > 0): ?>
        <div class="card">
            <div class="section-title">Entities Extracted</div>
            <div class="entity-row">
                <span style="color:#89612B">Entities Found</span>
                <span style="color:#F4E185"><?= $dossier['entityData']['entities_extracted'] ?></span>
            </div>
            <div class="entity-row">
                <span style="color:#89612B">Stored to Graph</span>
                <span style="color:#F4E185"><?= $dossier['entityData']['entities_stored'] ?></span>
            </div>
            <div class="entity-row">
                <span style="color:#89612B">Relationships Mapped</span>
                <span style="color:#F4E185"><?= $dossier['entityData']['relationships_stored'] ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- ── ACTIONS ── -->
        <div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:10px">
            <button onclick="window.print()" class="btn">Print / Save PDF</button>
            <a href="/commandcenter/prospect.php" class="back-link">← Run Another Dig</a>
        </div>

    </div>

<?php endif; ?>

</div>
</body>
</html>