index.php
- load: yes
- shell: yes
- content: yes but the shell.php was changed from original shell to the “Search Columns” look/shell so from here on out a Y in the shell loaded, just means it was loaded tho its not the correct design/shell

dashboard.php
- load:y
- shell:y wrong
- content:left column previous test json file content right column=text=home page working

ingest.php
- load:n
- shell:n
- content:{"error":"no content"}


files.php
- load:y
- shell:y wrong
- content:

search.php
- load:
- shell:
- content: left column working file tree. Right column=Index All Save Run Excavation | file view window | Result window from buttons=Index All Save Run Excavation 



-File: ai_process.php 
- load:y
- shell:n
- content:AI PROCESS LOADED + DB CONNECTED 

-File: api.php 
- load:y
- shell:n
- content:{"status":"error","message":"Invalid action"}


-File: bootstrap.php 
- load:n
- shell:n
- content:internal=<?php

$pdo = new PDO(
    "mysql:host=localhost;dbname=carrmulti_legaiseearchive;charset=utf8mb4",
    "legaiseeuser",
    "Jmc6253277$",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);


-File: brain.php 
- load:y
- shell:y
- content:🧠 LEGAISEE BRAIN OS
 Ingest Predict New Network View Graph Build Relationships Store Memory Patterns Alerts Dossier Graph Insights Cases Compare Networks Dossier v2 Recommendations Forecast Memory Weight Agent
Output...


-File: cluster.php 
- load:y
- shell:y yes wrong
- content:n

-File: cluster_engine.php 
- load:n
- shell:n
- content:Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 no such table: page in /home/carrmulti/www/www/commandcenter/cluster_engine.php:15 Stack trace: #0 /home/carrmulti/www/www/commandcenter/cluster_engine.php(15): PDO->query('\n SELECT id,...') #1 {main} thrown in /home/carrmulti/www/www/commandcenter/cluster_engine.php on line 15




-File: config.php 
- load:n
- shell:n
- content:<?php

define('OPENAI_API_KEY', 'PASTE_YOUR_KEY_HERE');


-File: create_session.php 
- load:n
- shell:n
- content:{"status":"error","message":"Missing client or query"} internal=<?php

// Accept JSON input
$data = json_decode(file_get_contents("php://input"), true);

$client = $data['client'] ?? null;
$query  = $data['query'] ?? null;

if (!$client || !$query) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing client or query"
    ]);
    exit;
}

// Clean client name
function clean($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9_\-]/', '_', $str);
    return preg_replace('/_+/', '_', $str);
}

$client = clean($client);

// Session ID (timestamp-based)
$session_id = date("Ymd_His");

// Base path
$baseDir = $_SERVER['DOCUMENT_ROOT'] . "/legaisee/clients/";

// Session path
$sessionPath = $baseDir . $client . "/excavations/" . $session_id . "/";

// Create folder structure
$folders = [
    $sessionPath,
    $sessionPath . "raw/",
    $sessionPath . "processed/",
    $sessionPath . "output/"
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// Session metadata
$sessionData = [
    "session_id" => $session_id,
    "client" => $client,
    "query" => $query,
    "status" => "created",
    "created_at" => date("Y-m-d H:i:s"),
    "platforms" => []
];

// Save session.json
file_put_contents(
    $sessionPath . "session.json",
    json_encode($sessionData, JSON_PRETTY_PRINT)
);

// RETURN CONTROL FLOW (IMPORTANT)
echo json_encode([
    "status" => "success",
    "session_id" => $session_id,
    "client" => $client,
    "redirect" => "session.php?session=" . $session_id . "&client=" . $client
]);

?>



-File:dashboard.php  
- load:y
- shell:y wrong
- content:left=json content right = HOME PAGE WORKING 

-File: db.php 
- load:n
- shell:n
- content:internal=<?php

// ========================================
// LEGAiSEE DATABASE CONNECTION (SQLite)
// ========================================

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {

    // Absolute path to database file
    $dbPath = __DIR__ . '/legaisee.db';

    // Create PDO connection
    $pdo = new PDO("sqlite:" . $dbPath);

    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {

    die("Database connection failed: " . $e->getMessage());

}


-File: dossier.php 
- load:n
- shell:n
- content:No set specified internal=

-File: embed_generate.php 
- load:n
- shell:n
- content:Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 no such table: page in /home/carrmulti/www/www/commandcenter/embed_generate.php:17 Stack trace: #0 /home/carrmulti/www/www/commandcenter/embed_generate.php(17): PDO->query('\n SELECT p.i...') #1 {main} thrown in /home/carrmulti/www/www/commandcenter/embed_generate.php on line 17
Internal content=<?php
require_once "db.php";

/*
======================================================
LEGAiSEE EMBEDDING GENERATOR
- Converts page content → OpenAI vector embeddings
======================================================
*/

// ⚠️ INSERT YOUR OPENAI KEY HERE
$OPENAI_API_KEY = "YOUR_API_KEY_HERE";

// -----------------------------
// FETCH UNEMBEDDED PAGES
// -----------------------------
$stmt = $pdo->query("
    SELECT p.id, p.title, pc.content
    FROM page p
    JOIN page_content pc ON pc.page_id = p.id
    WHERE p.embedding IS NULL
    LIMIT 20
");

$pages = $stmt->fetchAll();

// -----------------------------
// OPENAI EMBEDDING FUNCTION
// -----------------------------
function getEmbedding($text, $key) {

    $data = [
        "input" => $text,
        "model" => "text-embedding-3-small"
    ];

    $ch = curl_init("https://api.openai.com/v1/embeddings");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $key
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    return $json['data'][0]['embedding'] ?? null;
}

// -----------------------------
// PROCESS PAGES
// -----------------------------
foreach ($pages as $p) {

    $text = $p['title'] . " " . $p['content'];

    $embedding = getEmbedding($text, $OPENAI_API_KEY);

    if (!$embedding) continue;

    $stmt = $pdo->prepare("
        UPDATE page
        SET embedding = ?
        WHERE id = ?
    ");

    $stmt->execute([
        json_encode($embedding),
        $p['id']
    ]);
}

echo "Embedding Complete: " . count($pages) . " processed.";



-File: excavation.php 
- load:y
- shell:y wrong
- content:internal <?php
$pageTitle = "Excavation";
$contentFile = "modules/excavation_module.php";
include("shell.php");


-File: excavation_engine.php 
- load:
- shell:
- content:{"error":"no query"} internal=<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";

$input = json_decode(file_get_contents("php://input"), true);

$query = $input['query'] ?? '';

if (!$query) {
    echo json_encode(["error"=>"no query"]);
    exit;
}

$platforms = ["chatgpt","claude","gemini"];

$results = [];

foreach ($platforms as $p) {

    $response = "AI {$p} analysis for: {$query}";

    $strength = strlen($response) / 10;

    $type = (stripos($response, 'risk') !== false) ? 'anomaly' : 'signal';

    /* PUSH TO NETWORK */
    $url = "http://" . $_SERVER['HTTP_HOST'] . "/commandcenter/api/v8/network_add_node.php";

    $postData = http_build_query([
        "network_id" => $network_id,
        "type" => $type,
        "strength" => $strength
    ]);

    file_get_contents($url, false, stream_context_create([
        "http" => [
            "method" => "POST",
            "header" => "Content-type: application/x-www-form-urlencoded",
            "content" => $postData
        ]
    ]));

    $results[] = [
        "platform"=>$p,
        "status"=>"node_created"
    ];
}

echo json_encode([
    "success"=>true,
    "results"=>$results
]);



-File:  export_report.php 
- load:
- shell:
- content:No cluster ID  Internal=<?php

require_once __DIR__ . "/bootstrap.php";
require_once __DIR__ . "/lib/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

/* --------------------------
   INPUT
--------------------------- */
$clusterId = $_GET['id'] ?? 0;

if (!$clusterId) {
    die("No cluster ID");
}

/* --------------------------
   LOAD DATA
--------------------------- */
$stmt = $pdo->prepare("
    SELECT name, summary, insights, opportunities
    FROM clusters
    WHERE id = ?
");
$stmt->execute([$clusterId]);

$cluster = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cluster) {
    die("Cluster not found");
}

$stmt = $pdo->prepare("
    SELECT title, platform, created
    FROM page
    WHERE cluster_id = ?
    ORDER BY created DESC
    LIMIT 20
");
$stmt->execute([$clusterId]);

$records = $stmt->fetchAll();

/* --------------------------
   BUILD HTML
--------------------------- */
$html = '
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #111;
}

h1 { font-size: 22px; margin-bottom: 10px; }
h2 { font-size: 16px; margin-top: 25px; }

.section {
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.record {
    margin-bottom: 8px;
    font-size: 11px;
}
</style>

<h1>' . htmlspecialchars($cluster['name'] ?: "Cluster Report") . '</h1>

<div class="section">
<h2>Executive Summary</h2>
' . nl2br(htmlspecialchars($cluster['summary'])) . '
</div>

<div class="section">
<h2>Key Insights</h2>
' . nl2br(htmlspecialchars($cluster['insights'])) . '
</div>

<div class="section">
<h2>Opportunities</h2>
' . nl2br(htmlspecialchars($cluster['opportunities'])) . '
</div>

<div class="section">
<h2>Supporting Records</h2>
';

foreach ($records as $r) {
    $html .= '<div class="record">'
        . htmlspecialchars($r['title']) . ' | '
        . htmlspecialchars($r['platform']) . ' | '
        . $r['created']
        . '</div>';
}

$html .= '</div>';

/* --------------------------
   GENERATE PDF
--------------------------- */
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

/* --------------------------
   OUTPUT
--------------------------- */
$filename = "cluster_report_" . $clusterId . ".pdf";

$dompdf->stream($filename, ["Attachment" => true]);


-File: graph.php 
- load:y
- shell:y
- content: wrong search shell - ORIGINAL graph was a node/connection graph for file relations
Interna contentl=<?php
require_once("state.php");

$pageTitle = "Intelligence Graph";
$pageDesc  = "Node relationship map";

$contentFile = __DIR__ . "/modules/graph_module.php";

include(__DIR__ . "/shell.php");


-File: <?php
require_once("state.php");

$pageTitle = "Intelligence Graph";
$pageDesc  = "Node relationship map";

$contentFile = __DIR__ . "/modules/graph_module.php";

include(__DIR__ . "/shell.php");

- load:
- shell:
- content:


-File:  home.php 
- load:n
- shell:n
- content:placeholder=<div class="card">System Dashboard</div>


-File: indexer.php 
- load:n
- shell:n
- content:{"success":true,"indexed":5,"meta":5}


-File:  ingest.php 
- load:n
- shell:n
- content:{"error":"no content"}
-internal content=<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";

$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$platform = $_POST['platform'] ?? 'general';

if (!$content) {
    echo json_encode(["error"=>"no content"]);
    exit;
}

/* BASIC INTELLIGENCE SCORING */
$strength = strlen($content) / 20;

$type = (stripos($content, 'risk') !== false || stripos($content, 'problem') !== false)
    ? 'anomaly'
    : 'signal';

/* SEND TO NETWORK */
$url = "http://" . $_SERVER['HTTP_HOST'] . "/commandcenter/api/v8/network_add_node.php";

$postData = http_build_query([
    "network_id" => $network_id,
    "type" => $type,
    "strength" => $strength
]);

$options = [
    "http" => [
        "method" => "POST",
        "header" => "Content-type: application/x-www-form-urlencoded",
        "content" => $postData
    ]
];

$result = file_get_contents($url, false, stream_context_create($options));

echo json_encode([
    "success"=>true,
    "node_result"=>json_decode($result, true)
]);



-File: intelligence.php 
- load:n
- shell:n
- content:No file specified
-internal= <?php

/*
=====================================================
LEGAiSEE INTELLIGENCE ENGINE v1 (LOCAL)
=====================================================
- No API dependencies
- Rule-based extraction
- Outputs structured JSON next to source file
=====================================================
*/

if (!isset($_GET['file'])) {
    die("No file specified");
}

$baseDir = __DIR__ . "/normalized/";
$file = basename($_GET['file']);

$path = realpath($baseDir . $file);

if (!$path || strpos($path, $baseDir) !== 0 || !file_exists($path)) {
    die("Invalid file");
}

$content = file_get_contents($path);
$lines = explode("\n", strtolower($content));

$insights = [];
$actions = [];
$assets = [];
$entities = [];
$keywords = [];

/*
=====================================================
1. ENTITY DETECTION (basic known taxonomy)
=====================================================
*/

$knownEntities = [
    "chatgpt", "gpt", "claude", "gemini", "kimi",
    "openai", "anthropic", "google"
];

foreach ($knownEntities as $e) {
    if (stripos($content, $e) !== false) {
        $entities[] = $e;
    }
}

/*
=====================================================
2. RULE-BASED SENTENCE CLASSIFICATION
=====================================================
*/

foreach ($lines as $line) {

    $line = trim($line);
    if (strlen($line) < 4) continue;

    // ACTION DETECTION
    if (
        str_contains($line, "need to") ||
        str_contains($line, "should") ||
        str_contains($line, "must") ||
        str_contains($line, "going to") ||
        str_contains($line, "will build") ||
        str_contains($line, "we will")
    ) {
        $actions[] = $line;
    }

    // INSIGHT DETECTION
    if (
        str_contains($line, "problem") ||
        str_contains($line, "issue") ||
        str_contains($line, "bottleneck") ||
        str_contains($line, "confusing") ||
        str_contains($line, "important") ||
        str_contains($line, "realization")
    ) {
        $insights[] = $line;
    }

    // ASSET DETECTION
    if (
        str_contains($line, "template") ||
        str_contains($line, "framework") ||
        str_contains($line, "use this") ||
        str_contains($line, "copy") ||
        str_contains($line, "reusable") ||
        str_contains($line, "system")
    ) {
        $assets[] = $line;
    }

    /*
    =====================================================
    3. KEYWORD EXTRACTION (simple frequency model)
    =====================================================
    */

    $words = preg_split('/\s+/', preg_replace('/[^a-z0-9 ]/', '', $line));

    foreach ($words as $w) {
        if (strlen($w) < 4) continue;

        if (!isset($keywords[$w])) {
            $keywords[$w] = 0;
        }
        $keywords[$w]++;
    }
}

/*
=====================================================
4. SORT KEYWORDS BY FREQUENCY
=====================================================
*/

arsort($keywords);

/*
=====================================================
5. FINAL STRUCTURE
=====================================================
*/

$output = [
    "file" => $file,
    "insights" => array_values(array_unique($insights)),
    "actions" => array_values(array_unique($actions)),
    "assets" => array_values(array_unique($assets)),
    "entities" => array_values(array_unique($entities)),
    "keywords" => array_slice(array_keys($keywords), 0, 30)
];

$jsonFile = $path . ".intelligence.json";

file_put_contents($jsonFile, json_encode($output, JSON_PRETTY_PRINT));

echo "INTELLIGENCE GENERATED FOR: " . $file;

?>


-File: intelligence_dashboard.php 
- load:y
- shell:y
- content:📊 Intelligence Scoreboard
SIGNAL
No content
Strength: 300
SIGNAL
No content
Strength: 120
SIGNAL
No content
Strength: 100
SIGNAL
No content
Strength: 100
SIGNAL
No content
Strength: 100
SIGNAL
No content
Strength: 100
ANOMALY
No content
Strength: 80
ANOMALY
No content
Strength: 80
ANOMALY
No content
Strength: 80
ANOMALY
No content
Strength: 80
ANOMALY
No content
Strength: 80
SIGNAL
market growth opportunity with risk factors
Strength: 64
SIGNAL
major market risk and growth opportunity detected
Strength: 64
SIGNAL
major market risk and growth opportunity detected
Strength: 64
SIGNAL
major market risk and growth opportunity detected
Strength: 64
SIGNAL
market growth opportunity with risk
Strength: 63
SIGNAL
market growth opportunity with risk
Strength: 63
SIGNAL
market growth opportunity with risk
Strength: 63
SIGNAL
market growth opportunity with risk
Strength: 63



-File: legaisee.db
- load:n
- shell:n
- content:

-File: load_sets.php 
- load:
- shell:
- content:[] 
-internal content-<?php

$dir = __DIR__ . "/sets/";

if (!is_dir($dir)) {
    echo json_encode([]);
    exit;
}

$files = scandir($dir);
$sets = [];

foreach ($files as $f) {
    if (strpos($f, ".json") !== false) {
        $sets[] = json_decode(file_get_contents($dir . $f), true);
    }
}

echo json_encode($sets);



-File: mission
- load:
- shell:
- content:Workspace required. 
-internal content=<?php
require_once "db.php";

$workspaceId = $_GET['workspace_id'] ?? null;

if (!$workspaceId) {
    die("Workspace required.");
}

// -----------------------------
// WORKSPACE INFO
// -----------------------------
$stmt = $pdo->prepare("SELECT * FROM workspace WHERE id = ?");
$stmt->execute([$workspaceId]);
$workspace = $stmt->fetch();

// -----------------------------
// KPI METRICS
// -----------------------------
$total = $pdo->prepare("SELECT COUNT(*) FROM page WHERE workspace_id = ?");
$total->execute([$workspaceId]);
$totalPages = $total->fetchColumn();

$ai = $pdo->prepare("SELECT COUNT(*) FROM page WHERE workspace_id = ? AND ai_summary IS NOT NULL");
$ai->execute([$workspaceId]);
$aiPages = $ai->fetchColumn();

$clusters = $pdo->prepare("SELECT COUNT(DISTINCT cluster_id) FROM page WHERE workspace_id = ?");
$clusters->execute([$workspaceId]);
$clusterCount = $clusters->fetchColumn();

// -----------------------------
// HOT NODES (AI SCORE)
// -----------------------------
$stmt = $pdo->prepare("
    SELECT id, title, ai_score
    FROM page
    WHERE workspace_id = ?
    ORDER BY ai_score DESC
    LIMIT 5
");
$stmt->execute([$workspaceId]);
$hot = $stmt->fetchAll();

// -----------------------------
// CLUSTER BREAKDOWN
// -----------------------------
$stmt = $pdo->prepare("
    SELECT cluster_id, COUNT(*) as total
    FROM page
    WHERE workspace_id = ?
    GROUP BY cluster_id
    ORDER BY total DESC
");
$stmt->execute([$workspaceId]);
$clusterData = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mission Mode</title>

    <style>
        body {
            background:#0e0e0e;
            color:#f5f5f5;
            font-family: Arial;
        }

        .grid {
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap:20px;
            padding:20px;
        }

        .card {
            background:#1a1a1a;
            border:1px solid rgba(245,199,106,0.2);
            padding:15px;
            border-radius:10px;
        }

        .title {
            color:#f5c76a;
            margin-bottom:10px;
        }

        .stat {
            font-size:26px;
            color:#f5c76a;
        }

        .node {
            margin:5px 0;
        }

        a {
            color:#f5c76a;
            text-decoration:none;
        }

        .pill {
            display:inline-block;
            background:#f5c76a;
            color:#000;
            padding:3px 8px;
            border-radius:4px;
            font-size:12px;
        }
    </style>
</head>

<body>

<?php include "nav.php"; ?>

<h2 style="padding:20px; color:#f5c76a;">
    Mission Mode: <?= htmlspecialchars($workspace['name']) ?>
</h2>

<div class="grid">

    <!-- KPIs -->
    <div class="card">
        <div class="title">Mission Overview</div>

        <p>Total Nodes</p>
        <div class="stat"><?= $totalPages ?></div>

        <p>AI Processed</p>
        <div class="stat"><?= $aiPages ?></div>

        <p>Clusters</p>
        <div class="stat"><?= $clusterCount ?></div>
    </div>

    <!-- HOT NODES -->
    <div class="card">
        <div class="title">Priority Intelligence</div>

        <?php foreach ($hot as $h): ?>
            <div class="node">
                <a href="view.php?id=<?= $h['id'] ?>">
                    <?= htmlspecialchars($h['title']) ?>
                </a>
                <small>(<?= $h['ai_score'] ?>)</small>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- CLUSTERS -->
    <div class="card">
        <div class="title">Intelligence Clusters</div>

        <?php foreach ($clusterData as $c): ?>
            <div class="node">
                <span class="pill">Cluster <?= $c['cluster_id'] ?></span>
                <?= $c['total'] ?> nodes
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>



-File: parser.php 
- load:n
- shell:n
- content:n
-inteernal = <?php

function extractText($filePath, $ext) {

    $ext = strtolower($ext);

    // =====================
    // TXT / MD (DIRECT)
    // =====================
    if ($ext === "txt" || $ext === "md") {
        return file_get_contents($filePath);
    }

    // =====================
    // PDF (FALLBACK METHOD)
    // =====================
    if ($ext === "pdf") {

        // Try pdftotext if available
        $output = shell_exec("pdftotext " . escapeshellarg($filePath) . " -");

        if ($output && trim($output) !== "") {
            return $output;
        }

        return "[PDF: UNABLE TO EXTRACT TEXT - STORED RAW]";
    }

    // =====================
    // DOCX (ZIP XML PARSE)
    // =====================
    if ($ext === "docx") {

        $zip = new ZipArchive;
        if ($zip->open($filePath) === TRUE) {

            $xml = $zip->getFromName("word/document.xml");
            $zip->close();

            if ($xml) {
                $xml = strip_tags($xml);
                return $xml;
            }
        }

        return "[DOCX: UNABLE TO EXTRACT TEXT]";
    }

    // =====================
    // XLSX (BASIC EXTRACTION)
    // =====================
    if ($ext === "xlsx") {

        $zip = new ZipArchive;
        $text = "";

        if ($zip->open($filePath) === TRUE) {

            $xml = $zip->getFromName("xl/sharedStrings.xml");

            if ($xml) {
                $text = strip_tags($xml);
            }

            $zip->close();
        }

        return $text ?: "[XLSX: BASIC EXTRACTION FAILED]";
    }

    // =====================
    // UNKNOWN FILE TYPE
    // =====================
    return "[UNSUPPORTED FILE TYPE]";
}

function normalizeFile($filePath, $meta = []) {

    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

    $text = extractText($filePath, $ext);

    $hash = md5($filePath . time());

    $baseDir = __DIR__ . "/normalized/";

    $client = $meta['client'] ?? "general";

    $dir = $baseDir . $client . "/";

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $mdFile = $dir . $hash . ".md";
    $jsonFile = $dir . $hash . ".json";

    file_put_contents($mdFile, $text);

    $metaOut = array_merge($meta, [
        "source_file" => $filePath,
        "type" => $ext,
        "word_count" => str_word_count($text),
        "timestamp" => date("Y-m-d H:i:s"),
        "extracted_from" => "parser"
    ]);

    file_put_contents($jsonFile, json_encode($metaOut, JSON_PRETTY_PRINT));

    return $mdFile;
}

?>


-File: README.md 
- load:y
- shell:n
- content:# LEGAiSEE Command Center v1.0

Complete Business Archaeology Platform with Multi-AI Excavation

## Features

âœ… Multi-AI Excavation Interface (4 platforms simultaneously)
âœ… Chat Archive with full-text search
âœ… Real Legaisee logo integration
âœ… SQLite database (no MySQL needed)
âœ… Mobile-responsive design

## Files

- setup.php - System initialization
- index.php - Dashboard with logo
- excavation.php - Multi-AI query launcher
- search.php - Full-text search with clickable results
- view.php - Chat viewer with export
- upload.php - File upload interface
- api.php - Backend API

## Installation

1. Upload all files to your server
2. Visit setup.php
3. Click "Initialize System"
4. Done!

## Logo

The system uses your real Legaisee logo from:
https://www.legaisee.com/Images/Legaisee-sm-300.png

No configuration needed - it loads automatically.

## Next Steps

Configure API keys in settings to enable live Multi-AI queries:
- OpenAI (ChatGPT)
- Anthropic (Claude)
- Google (Gemini)
- Perplexity

Without API keys, the excavation interface works in demo mode.

;



-File: report.php 
- load:y
- shell:y bad search shell
- content:<?php
require_once __DIR__ . "/bootstrap.php";

$clusterId = $_GET['id'] ?? 0;

$pageTitle = "Client Intelligence Report";
$pageDesc  = "Strategic analysis output";

$contentFile = __DIR__ . "/modules/report_module.php";

include __DIR__ . "/shell.php";


-File: save_set.php 
- load:n
- shell:n
- content:{"error":"Invalid input"} 
-internal=<?php

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$name     = $data['name'] ?? "";
$query    = $data['query'] ?? "";
$system   = $data['system'] ?? "";
$platform = $data['platform'] ?? "";
$client   = $data['client'] ?? "";

if (!$name) {
    echo json_encode(["error" => "Set name required"]);
    exit;
}

$safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', strtolower($name));

$dir = __DIR__ . "/sets/";
if (!is_dir($dir)) mkdir($dir, 0777, true);

$file = $dir . "set_" . $safeName . ".json";

$payload = [
    "name" => $name,
    "query" => $query,
    "system" => $system,
    "platform" => $platform,
    "client" => $client,
    "created" => date("Y-m-d H:i:s")
];

file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "file" => basename($file)]);


-File: saved_views.php 
- load:n
- shell:n
- content:Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 no such table: saved_views in /home/carrmulti/www/www/commandcenter/saved_views.php:29 Stack trace: #0 /home/carrmulti/www/www/commandcenter/saved_views.php(29): PDO->query('SELECT * FROM s...') #1 {main} thrown in /home/carrmulti/www/www/commandcenter/saved_views.php on line 29 
Internal=<?php
require_once "db.php";

// -----------------------------
// SAVE NEW VIEW
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO saved_views (name, project, platform, type, keyword)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['name'] ?? '',
        $_POST['project'] ?? null,
        $_POST['platform'] ?? null,
        $_POST['type'] ?? null,
        $_POST['keyword'] ?? null
    ]);

    header("Location: saved_views.php");
    exit;
}

// -----------------------------
// LOAD SAVED VIEWS
// -----------------------------
$views = $pdo->query("SELECT * FROM saved_views ORDER BY created DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saved Intelligence Views</title>

    <style>
        body {
            background:#0e0e0e;
            color:#f5f5f5;
            font-family: Arial;
        }

        .container {
            padding:20px;
        }

        .card {
            background:#1a1a1a;
            border:1px solid rgba(245,199,106,0.2);
            padding:15px;
            margin-bottom:10px;
            border-radius:10px;
        }

        .btn {
            background: linear-gradient(135deg, #f5c76a, #c89b3c);
            border:none;
            padding:8px 12px;
            cursor:pointer;
            display:inline-block;
            margin-top:5px;
            color:#000;
            text-decoration:none;
        }

        input {
            padding:8px;
            margin:5px;
            background:#111;
            border:1px solid #333;
            color:#fff;
        }

        .form-box {
            background:#151515;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        }
    </style>
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

<h2 style="color:#f5c76a;">Saved Intelligence Views</h2>

<!-- =========================
     SAVE NEW VIEW FORM
========================= -->
<div class="form-box">

<form method="POST">

    <input type="text" name="name" placeholder="View Name" required>

    <input type="text" name="project" placeholder="Project (optional)">
    <input type="text" name="platform" placeholder="Platform (optional)">
    <input type="text" name="type" placeholder="Type (optional)">
    <input type="text" name="keyword" placeholder="Keyword (optional)">

    <button class="btn" type="submit">Save View</button>

</form>

</div>

<!-- =========================
     SAVED VIEWS LIST
========================= -->

<?php foreach ($views as $v): ?>

    <div class="card">
        <strong><?= htmlspecialchars($v['name']) ?></strong><br>

        <small>
            Project: <?= $v['project'] ?? 'ANY' ?> |
            Platform: <?= $v['platform'] ?? 'ANY' ?> |
            Type: <?= $v['type'] ?? 'ANY' ?> |
            Keyword: <?= $v['keyword'] ?? 'ANY' ?>
        </small>

        <br>

        <a class="btn"
           href="search.php?project=<?= urlencode($v['project']) ?>
           &platform=<?= urlencode($v['platform']) ?>
           &type=<?= urlencode($v['type']) ?>
           &q=<?= urlencode($v['keyword']) ?>">
           Run View
        </a>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>



-File: search_dual.php 
- load:y
- shell:y
- content: this was ORIGINAL 2 column setup before adding a few more things. Shell is working for what i t was
Dashboard Search
Search
 Execute
Select A...
Select B...


-File: semantic_engine.php 
- load:n
- shell:n
- content:Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 no such table: page in /home/carrmulti/www/www/commandcenter/semantic_engine.php:5 Stack trace: #0 /home/carrmulti/www/www/commandcenter/semantic_engine.php(5): PDO->query('\n SELECT id,...') #1 {main} thrown in /home/carrmulti/www/www/commandcenter/semantic_engine.php on line 5
-Internal=<?php
require_once "db.php";

// LOAD PAGES WITH EMBEDDINGS
$stmt = $pdo->query("
    SELECT id, title, embedding, project, platform
    FROM page
    WHERE embedding IS NOT NULL
");

$pages = $stmt->fetchAll();

function cosine($a, $b) {

    $a = json_decode($a, true);
    $b = json_decode($b, true);

    if (!$a || !$b) return 0;

    $dot = 0;
    $magA = 0;
    $magB = 0;

    for ($i = 0; $i < count($a); $i++) {
        $dot += $a[$i] * $b[$i];
        $magA += $a[$i] * $a[$i];
        $magB += $b[$i] * $b[$i];
    }

    return $dot / (sqrt($magA) * sqrt($magB));
}

$update = $pdo->prepare("UPDATE page SET related_ids = ? WHERE id = ?");

foreach ($pages as $p1) {

    $related = [];

    foreach ($pages as $p2) {

        if ($p1['id'] == $p2['id']) continue;

        $score = cosine($p1['embedding'], $p2['embedding']);

        if ($score > 0.78) {
            $related[$p2['id']] = $score;
        }
    }

    arsort($related);
    $top = array_slice(array_keys($related), 0, 5);

    $update->execute([
        implode(",", $top),
        $p1['id']
    ]);
}

echo "Semantic clustering complete.";



-File:  session.php 
- load:n
- shell:n
- content:Session not found (missing parameters). 
-internal= <?php


$client = $_GET['client'] ?? null;
$session_id = $_GET['session'] ?? null;

if (!$client || !$session_id) {
    die("Session not found (missing parameters).");
}

$basePath = $_SERVER['DOCUMENT_ROOT'] . "/legaisee/clients/";

$sessionPath = $basePath . $client . "/excavations/" . $session_id . "/";
$rawPath = $sessionPath . "raw/";

if (!is_dir($rawPath)) {
    die("Raw session data not found.");
}

// Load session metadata
$sessionMetaFile = $sessionPath . "session.json";
$sessionMeta = [];

if (file_exists($sessionMetaFile)) {
    $sessionMeta = json_decode(file_get_contents($sessionMetaFile), true);
}

// Get all files
$files = glob($rawPath . "*.md");

$digGroups = [];

foreach ($files as $file) {

    $name = basename($file);

    // skip metadata artifacts
    if (strpos($name, "metadata") !== false) continue;

    // extract dig + platform
    if (preg_match('/^(\d+)_([a-zA-Z]+)/', $name, $m)) {

        $dig = $m[1];
        $platform = strtoupper($m[2]);

        $content = file_get_contents($file);

        $digGroups[$dig][] = [
            "file" => $name,
            "platform" => $platform,
            "content" => $content
        ];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Session View</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0a0a0f;
            color: #e0e0e0;
            margin: 0;
        }

        .header {
            padding: 20px;
            border-bottom: 2px solid #FFD700;
            color: #FFD700;
        }

        .meta {
            font-size: 13px;
            color: #aaa;
            margin-top: 5px;
        }

        .dig-title {
            padding: 15px 20px;
            background: rgba(255,215,0,0.05);
            border-top: 1px solid rgba(255,215,0,0.2);
            border-bottom: 1px solid rgba(255,215,0,0.2);
            color: #FFD700;
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,215,0,0.15);
            border-radius: 10px;
            padding: 15px;
        }

        .platform {
            color: #FFD700;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .content {
            white-space: pre-wrap;
            font-size: 12px;
            line-height: 1.5;
            color: #ccc;
            max-height: 300px;
            overflow: auto;
        }

    </style>
</head>

<body>

<div class="header">
    🧠 Session View

    <div class="meta">
        Client: <?php echo htmlspecialchars($client); ?> |
        Session: <?php echo htmlspecialchars($session_id); ?> |
        Query: <?php echo htmlspecialchars($sessionMeta['query'] ?? 'N/A'); ?>
    </div>
</div>

<?php if (empty($digGroups)): ?>
    <div style="padding:20px;color:#888;">
        No excavation data found in this session.
    </div>
<?php endif; ?>

<?php foreach ($digGroups as $dig => $items): ?>

    <div class="dig-title">DIG <?php echo $dig; ?></div>

    <div class="grid">

        <?php foreach ($items as $item): ?>

            <div class="card">

                <div class="platform">
                    <?php echo $item['platform']; ?>
                </div>

                <div class="content">
                    <?php echo htmlspecialchars($item['content']); ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endforeach; ?>

</body>
</html>


-File: setup.php 
- load:y
- shell:y
- content:
Welcome
LEGAiSEE Command Center v1.0
Archaeology Intelligence Platform
✓ Database already exists
Go to Dashboard → 

-File:  setup_sqlite.php 
- load:y
- shell:y
- content:◆ SQLite Setup
This creates a legaisee.db file (like your existing system).
No MySQL database needed.
Create Database



-File: shell.php 
- load:y
- shell:y
- content:THIS IS WRONG!!! THIS IS SEARCH COLUMNS, NOT CSS STYLE

-File: state.php 
- load:N
- shell:N
- content:N
-INTERNAL=<?php
session_start();

function set_last_search($query, $results = []) {
    $_SESSION['ux']['last_search'] = [
        'query' => $query,
        'results' => $results
    ];
}

function get_last_search() {
    return $_SESSION['ux']['last_search'] ?? null;
}

function set_last_view($file) {
    $_SESSION['ux']['last_view'] = $file;
}

function get_last_view() {
    return $_SESSION['ux']['last_view'] ?? null;
}
?>


-File:  test_visual.php 
- load:y
- shell:y
- content:Hero Card
Radial top glow + prestige border system
Service Card
Primary operational module styling
Timeline Card
Historical / archeology narrative structure
Navigation Link


-File: view.php 
- load:y
- shell:y wrong
- content:THIS WAS ORIGINAL VIEWER FOR FILE SEARCH, THEN ADDED DOUBLE COLUMN COMPARE, THEN DOUBLE COLUMN MORPHED INTO SEARCH INSTEAD OF FILE VIEWER

-File: view_file - Copy.php 
- load:N
- shell:N
- content:File not found. 

-File: view_file.php 
- load:N
- shell:N
- content:File not found. 
-INTERNAL=<?php
$file = $_GET['file'] ?? '';

if (!$file || !file_exists($file)) {
    die("File not found.");
}

// 🔹 Load content safely
$content = file_get_contents($file);

// 🔹 Fix encoding issues
$content = mb_convert_encoding($content, 'UTF-8', 'auto');

// 🔹 Try to load metadata
$metaFile = dirname($file) . "/metadata.json";
$meta = [];

if (file_exists($metaFile)) {
    $meta = json_decode(file_get_contents($metaFile), true);
}

// Defaults
$platform = strtoupper($meta['platform'] ?? 'UNKNOWN');
$title = $meta['title'] ?? basename($file);
$date = $meta['timestamp'] ?? date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 100%);
            color: #e0e0e0;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
        }

   .header {
            background: rgba(0,0,0,0.7);
            border-bottom: 2px solid #FFD700;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }
}
.meta {
    color: #FFD700;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 12px;
}

.actions {
    margin-top: 10px;
}

.btn {
    display: inline-block;
    margin-right: 12px;
    padding: 8px 16px;
    background: #FFD700;
    color: #000;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
}

        .meta {
            color: #FFD700;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .actions {
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            margin-right: 10px;
            padding: 6px 12px;
            background: #FFD700;
            color: #000;
            border-radius: 15px;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
        }

        .content {
            white-space: pre-wrap;
            line-height: 1.6;
            background: rgba(255,255,255,0.03);
            padding: 20px;
            border-radius: 10px;
        }
    </style>

    <script>
        function copyText() {
            navigator.clipboard.writeText(document.getElementById("content").innerText);
            alert("Copied to clipboard");
        }

        function printPage() {
            window.print();
        }

        function exportMD() {
            const text = document.getElementById("content").innerText;
            const blob = new Blob([text], { type: "text/markdown" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "export.md";
            link.click();
        }
    </script>

</head>
<body>

<div class="container">

    <div class="header">
        <div class="meta">
            <?php echo $platform; ?> — <?php echo date("F j, Y g:i A", strtotime($date)); ?>
        </div>

        <div class="actions">
            <span class="btn" onclick="copyText()">📋 Copy</span>
            <span class="btn" onclick="printPage()">🖨️ Print</span>
            <span class="btn" onclick="exportMD()">⬇️ Export MD</span>
        </div>
    </div>

    <h1 style="margin-bottom:20px;"><?php echo htmlspecialchars($title); ?></h1>

    <div id="content" class="content">
        <?php echo htmlspecialchars($content); ?>
    </div>

</div>

</body>
</html>


-File:  xxxlayout.php 
- load:Y
- shell:Y
- content:ORIGINAL cOMMAND cENTER/INDEX/DASHBOARD=Dashboard Search Ingest Graph
NO CONTENT PASSED TO LAYOUT
iNTERNAL=<!DOCTYPE html>
<html>
<head>
    <title>LEGAiSEE Command Center</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin:0;
            background:#0e0e0e;
            color:#f5f5f5;
            font-family: Arial, sans-serif;
        }

        .topbar {
            background:#111;
            padding:12px 20px;
            border-bottom:1px solid rgba(245,199,106,0.2);
        }

        .topbar a {
            color:#f5c76a;
            text-decoration:none;
            margin-right:15px;
        }

        .container {
            padding:20px;
        }

        .card {
            background:#1a1a1a;
            border:1px solid rgba(245,199,106,0.2);
            border-radius:10px;
            padding:15px;
            margin-bottom:15px;
        }

        input, textarea {
            width:100%;
            padding:10px;
            margin:5px 0;
            background:#111;
            border:1px solid rgba(245,199,106,0.3);
            color:#f5f5f5;
            border-radius:6px;
        }

        button {
            background:#f5c76a;
            color:#000;
            padding:10px 15px;
            border:none;
            border-radius:6px;
        }
    </style>
</head>

<body>

<div class="topbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="search.php">Search</a>
    <a href="ingest.php">Ingest</a>
    <a href="graph.php">Graph</a>
</div>

<div class="container">

    <?php
    if (isset($content)) {
        echo $content;
    } else {
        echo "<div class='card'>NO CONTENT PASSED TO LAYOUT</div>";
    }
    ?>

</div>

</body>
</html>


-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:


-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:


-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:


-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:


-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:





-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

-File: 
- load:
- shell:
- content:

