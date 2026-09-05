-File: cluster_module.php 
- load:n
- shell:n
- content:No cluster selected 
- Internal:<?php


$clusterId = $_GET['id'] ?? 0;


if (!$clusterId) {
    echo "<p>No cluster selected</p>";
    return;
}


/* --------------------------
   LOAD CLUSTER NAME
--------------------------- */
$stmt = $pdo->prepare("SELECT name FROM clusters WHERE id = ?");
$stmt->execute([$clusterId]);
$clusterName = $stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT summary FROM clusters WHERE id = ?");
$stmt->execute([$clusterId]);
$summary = $stmt->fetchColumn();


/* --------------------------
   LOAD RECORDS
--------------------------- */
$stmt = $pdo->prepare("
    SELECT id, title, project, platform, created
    FROM page
    WHERE cluster_id = ?
    ORDER BY created DESC
");


$stmt->execute([$clusterId]);
$rows = $stmt->fetchAll();


?>


<h2 style="margin-bottom:10px;">
    <?= htmlspecialchars($clusterName ?: "Cluster " . $clusterId) ?>
</h2>


<?php if ($summary): ?>
    <div style="
        margin-bottom:20px;
        padding:15px;
        border:1px solid rgba(245,199,106,0.2);
        border-radius:10px;
        background:rgba(245,199,106,0.05);
        line-height:1.6;
    ">
        <?= htmlspecialchars($summary) ?>
    </div>
    <?php
$stmt = $pdo->prepare("SELECT insights FROM clusters WHERE id = ?");
$stmt->execute([$clusterId]);
$insights = $stmt->fetchColumn();
?>


<?php if ($insights): ?>
    <div style="
        margin-bottom:20px;
        padding:15px;
        border:1px solid rgba(245,199,106,0.2);
        border-radius:10px;
        background:rgba(245,199,106,0.05);
        line-height:1.6;
    ">
        <strong>Key Insights:</strong><br><br>
        <?= nl2br(htmlspecialchars($insights)) ?>
    </div>
    <?php
$stmt = $pdo->prepare("SELECT opportunities FROM clusters WHERE id = ?");
$stmt->execute([$clusterId]);
$opportunities = $stmt->fetchColumn();
?>


<?php if ($opportunities): ?>
    <div style="
        margin-bottom:20px;
        padding:15px;
        border:1px solid rgba(245,199,106,0.25);
        border-radius:10px;
        background:rgba(255,80,80,0.05);
        line-height:1.6;
    ">
        <strong>Opportunities:</strong><br><br>
        <?= nl2br(htmlspecialchars($opportunities)) ?>
    </div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>


<p style="opacity:0.6;margin-bottom:20px;">
    <?= count($rows) ?> records in this theme
</p>


<div class="card-grid">


<?php foreach ($rows as $r): ?>


    <div class="service-card">
        <h3><?= htmlspecialchars($r['title']) ?></h3>


        <p>
            <?= htmlspecialchars($r['project']) ?> |
            <?= htmlspecialchars($r['platform']) ?>
        </p>


        <p style="font-size:12px;opacity:0.6;">
            <?= $r['created'] ?>
        </p>


        <a href="view.php?id=<?= $r['id'] ?>" class="btn btn-primary">
            Open Record
        </a>
        <a href="report.php?id=<?= $clusterId ?>" class="btn btn-primary" style="margin-bottom:20px;">
    Generate Client Report
</a>
    </div>


<?php endforeach; ?>


</div>


-File: compare_module.php  
- load:n
- shell:n
- content:Compare Intelligence Layer
Baseline structure for A/B comparison system.
Column A
Select a file or search result to load.
Column B
Select a second file to compare.

- Internal:<div class="card">
  <h2>Compare Intelligence Layer</h2>
  <p>Baseline structure for A/B comparison system.</p>
</div>


<div class="compare">


  <div class="compare-box">
    <h3>Column A</h3>
    <p>Select a file or search result to load.</p>
  </div>


  <div class="compare-box">
    <h3>Column B</h3>
    <p>Select a second file to compare.</p>
  </div>


</div>


-File: dashboard_module.php 
- load:n
- shell:n
- content:Warning: Undefined variable $pdo in /home/carrmulti/www/www/commandcenter/modules/dashboard_module.php on line 2

Fatal error: Uncaught Error: Call to a member function query() on null in /home/carrmulti/www/www/commandcenter/modules/dashboard_module.php:2 Stack trace: #0 {main} thrown in /home/carrmulti/www/www/commandcenter/modules/dashboard_module.php on line 2
- Internal:<?php
$total = $pdo->query("SELECT COUNT(*) FROM page")->fetchColumn();
?>


<div class="card-grid">


    <div class="service-card">
        <h3>Search</h3>
        <p>Query stored intelligence</p>
        <a href="search.php" class="btn btn-primary">Open</a>
    </div>


    <div class="service-card">
        <h3>Ingest</h3>
        <p>Create new record</p>
        <a href="ingest.php" class="btn btn-primary">Open</a>
    </div>


    <div class="service-card">
        <h3>Files</h3>
        <p>Browse archive</p>
        <a href="files.php" class="btn btn-primary">Open</a>
    </div>


</div>


<br><br>


<h2 style="opacity:0.8;">Intelligence Layer</h2>


<div class="card-grid">


    <div class="service-card">
        <h3>Graph</h3>
        <p>Explore relationships between nodes</p>
        <a href="graph.php" class="btn btn-primary">Open</a>
    </div>


</div>


-File: excavation_module.php 
- load:y
- shell:n
- content:Excavation Control

Create Client
 Create Client

Select Client
     Loading... 

Create Session
 Create Session

Select Session
     Select Client First 


Run Excavation 
- Internal:<?php
// ========================================
// LEGAiSEE EXCAVATION MODULE (FIXED)
// NO DB INCLUDE HERE
// ========================================
?>


<h1>Excavation Control</h1>


<hr>


<h3>Create Client</h3>
<input type="text" id="clientName" placeholder="Enter Client Name">
<button onclick="createClient()">Create Client</button>


<br><br>


<h3>Select Client</h3>
<select id="clientSelect">
    <option value="">Loading...</option>
</select>


<br><br>


<h3>Create Session</h3>
<input type="text" id="sessionName" placeholder="Session Name">
<button onclick="createSession()">Create Session</button>


<br><br>


<h3>Select Session</h3>
<select id="sessionSelect">
    <option value="">Select Client First</option>
</select>


<br><br><br>


<button onclick="runExcavation()" style="padding:10px 20px; font-size:16px;">
    Run Excavation
</button>


<hr>


<pre id="outputBox" style="background:#111; color:#0f0; padding:15px;"></pre>


<script>


// LOAD CLIENTS
async function loadClients() {
    const res = await fetch('api.php?action=get_clients');
    const data = await res.json();


    const select = document.getElementById('clientSelect');
    select.innerHTML = '<option value="">Select Client</option>';


    data.forEach(client => {
        const opt = document.createElement('option');
        opt.value = client.id;
        opt.textContent = client.name;
        select.appendChild(opt);
    });
}


// CREATE CLIENT
async function createClient() {
    const name = document.getElementById('clientName').value;


    if (!name) {
        alert("Enter client name");
        return;
    }


    await fetch('api.php?action=create_client', {
        method: 'POST',
        body: new URLSearchParams({ name })
    });


    document.getElementById('clientName').value = "";
    loadClients();
}


// LOAD SESSIONS
async function loadSessions() {
    const clientId = document.getElementById('clientSelect').value;


    if (!clientId) return;


    const res = await fetch('api.php?action=get_sessions&client_id=' + clientId);
    const data = await res.json();


    const select = document.getElementById('sessionSelect');
    select.innerHTML = '<option value="">Select Session</option>';


    data.forEach(session => {
        const opt = document.createElement('option');
        opt.value = session.id;
        opt.textContent = session.session_name;
        select.appendChild(opt);
    });
}


// CREATE SESSION
async function createSession() {
    const clientId = document.getElementById('clientSelect').value;
    const sessionName = document.getElementById('sessionName').value;


    if (!clientId || !sessionName) {
        alert("Select client and enter session name");
        return;
    }


    await fetch('api.php?action=create_session', {
        method: 'POST',
        body: new URLSearchParams({
            client_id: clientId,
            session_name: sessionName
        })
    });


    document.getElementById('sessionName').value = "";
    loadSessions();
}


// RUN EXCAVATION
async function runExcavation() {
    const sessionId = document.getElementById('sessionSelect').value;


    if (!sessionId) {
        alert("Select a session first");
        return;
    }


    document.getElementById('outputBox').textContent = "Running...";


    const res = await fetch('excavation_engine.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ session_id: sessionId })
    });


    const data = await res.json();


    document.getElementById('outputBox').textContent = JSON.stringify(data, null, 2);
}


// EVENTS
document.getElementById('clientSelect').addEventListener('change', loadSessions);


// INIT
loadClients();


</script>


-File: files_module.php 
- load:n
- shell:n
- content:Warning: Undefined variable $pdo in /home/carrmulti/www/www/commandcenter/modules/files_module.php on line 3

Fatal error: Uncaught Error: Call to a member function query() on null in /home/carrmulti/www/www/commandcenter/modules/files_module.php:3 Stack trace: #0 {main} thrown in /home/carrmulti/www/www/commandcenter/modules/files_module.php on line 3 
- Internal:<?php


$stmt = $pdo->query("
    SELECT id, title, project, platform, type, created
    FROM page
    ORDER BY created DESC
    LIMIT 100
");


$rows = $stmt->fetchAll();


?>


<div class="card-grid">


<?php foreach ($rows as $r): ?>


    <a href="view.php?id=<?= $r['id'] ?>" style="text-decoration:none; color:inherit;">


        <div class="service-card">


            <h3><?= htmlspecialchars($r['title']) ?></h3>


            <p>
                <?= htmlspecialchars($r['project']) ?> |
                <?= htmlspecialchars($r['platform']) ?> |
                <?= htmlspecialchars($r['type']) ?>
            </p>


            <p style="font-size:12px; opacity:0.6;">
                <?= $r['created'] ?>
            </p>


        </div>


    </a>


<?php endforeach; ?>


</div>


-File: graph_module.php 
- load:n
- shell:n
- content:n
- Internal:<?php
/* GRAPH MODULE WITH CLUSTER FILTER UI */
?>


<!-- FILTER BAR -->
<div id="clusterFilters" style="
    padding:10px;
    border:1px solid rgba(245,199,106,0.2);
    border-radius:10px;
    margin-bottom:10px;
    display:flex;
    flex-wrap:wrap;
    gap:8px;
"></div>


<!-- GRAPH -->
<div style="
    width:100%;
    height:650px;
    border:1px solid rgba(245,199,106,0.25);
    border-radius:12px;
    overflow:hidden;
">
    <div id="graph" style="width:100%; height:100%;"></div>
</div>


<script src="https://d3js.org/d3.v7.min.js"></script>


<script>


let activeClusters = new Set();


fetch("/commandcenter/data/graph_data.php")
    .then(res => res.json())
    .then(data => {


        if (data.error) {
            document.getElementById("graph").innerHTML =
                "<div style='color:red;padding:20px;'>Data error</div>";
            return;
        }


        const nodes = data.nodes || [];
        const links = data.links || [];


        if (!nodes.length) {
            document.getElementById("graph").innerHTML =
                "<div style='color:#f5c76a;padding:20px;'>No nodes</div>";
            return;
        }


        buildFilters(nodes);
        renderGraph(nodes, links);
    });


/* =========================
   BUILD FILTER BUTTONS
========================= */
function buildFilters(nodes) {


    const container = document.getElementById("clusterFilters");


    const clusterMap = {};


    nodes.forEach(n => {
        const cid = n.cluster || 0;
        const name = n.cluster_name || "Unlabeled";


        if (!clusterMap[cid]) {
            clusterMap[cid] = name;
            activeClusters.add(cid);
        }
    });


    Object.entries(clusterMap).forEach(([cid, name]) => {


        const btn = document.createElement("div");


        btn.innerText = name;
        btn.dataset.cid = cid;


        btn.style.padding = "6px 10px";
        btn.style.border = "1px solid rgba(245,199,106,0.3)";
        btn.style.borderRadius = "6px";
        btn.style.cursor = "pointer";
        btn.style.fontSize = "12px";
        btn.style.background = "rgba(245,199,106,0.15)";


        btn.onclick = () => {


            if (activeClusters.has(cid)) {
                activeClusters.delete(cid);
                btn.style.opacity = 0.3;
            } else {
                activeClusters.add(cid);
                btn.style.opacity = 1;
            }


            updateVisibility();
        };


        container.appendChild(btn);
    });
}


/* =========================
   GRAPH RENDER
========================= */
function renderGraph(nodes, links) {


    const container = document.getElementById("graph");
    const width = container.offsetWidth || 800;
    const height = container.offsetHeight || 650;


    const svg = d3.select("#graph")
        .append("svg")
        .attr("width", width)
        .attr("height", height);


    const simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(d => d.id).distance(120))
        .force("charge", d3.forceManyBody().strength(-250))
        .force("center", d3.forceCenter(width / 2, height / 2));


    /* LINKS */
    const link = svg.append("g")
        .selectAll("line")
        .data(links)
        .enter()
        .append("line")
        .style("stroke", "rgba(245,199,106,0.35)")
        .style("stroke-width", d => Math.max(1, d.weight || 1));


    /* NODES */
    const node = svg.append("g")
        .selectAll("circle")
        .data(nodes)
        .enter()
        .append("circle")
        .attr("r", 6)
        .style("fill", d => {
            const colors = [
                "#f5c76a","#8be9fd","#ff79c6",
                "#50fa7b","#bd93f9","#ffb86c"
            ];
            return colors[(d.cluster || 0) % colors.length];
        })
        .style("cursor", "pointer")
        .on("click", (event, d) => {
    window.location = "cluster.php?id=" + d.cluster;
}
        });


    /* LABELS */
    const label = svg.append("g")
        .selectAll("text")
        .data(nodes)
        .enter()
        .append("text")
        .text(d => d.title)
        .style("font-size", "10px")
        .style("fill", "#fff");


    simulation.on("tick", () => {


        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);


        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);


        label
            .attr("x", d => d.x + 8)
            .attr("y", d => d.y + 3);
    });


    /* STORE GLOBAL FOR FILTER */
    window._graph = { node, link, nodes, links };
}


/* =========================
   FILTER LOGIC
========================= */
function updateVisibility() {


    const { node, link, nodes } = window._graph;


    node.style("opacity", d =>
        activeClusters.has(String(d.cluster)) ||
        activeClusters.has(d.cluster) ? 1 : 0.1
    );


    link.style("opacity", d => {
        return (
            activeClusters.has(d.source.cluster) &&
            activeClusters.has(d.target.cluster)
        ) ? 1 : 0.05;
    });
}
.on("click", (event, d) => {
    window.location = "cluster.php?id=" + d.cluster;
})
.on("dblclick", (event, d) => {
    window.location = "view.php?id=" + d.id;
})
</script>


-File: ingest_module.php 
- load:y
- shell:n
- content:Intelligence Ingest
       Legaisee Intelligence (Archaeology)     General Storage / Backup       ChatGPT     Claude     Gemini     Perplexity     Manual Entry  

Ingest


- Internal:<?php


$baseDir = __DIR__ . "/../normalized/";


$legaiseeDir = $baseDir . "legaisee/";
$generalDir  = $baseDir . "general/";


if (!is_dir($legaiseeDir)) mkdir($legaiseeDir, 0777, true);
if (!is_dir($generalDir)) mkdir($generalDir, 0777, true);


?>


<div class="card">


<h2 style="color:#FFD700;">Intelligence Ingest</h2>


<form method="POST">


<!-- TITLE -->
<input type="text" name="title" placeholder="Title / Description" style="
width:100%; padding:10px; margin-bottom:10px;
background:#111; color:#fff; border:1px solid #FFD700;
">


<!-- CLIENT -->
<input type="text" name="client" placeholder="Client (for Legaisee)" style="
width:100%; padding:10px; margin-bottom:10px;
background:#111; color:#fff; border:1px solid #FFD700;
">


<!-- SYSTEM TYPE -->
<select name="system" style="
width:100%; padding:10px; margin-bottom:10px;
background:#111; color:#fff; border:1px solid #FFD700;
">
    <option value="legaisee">Legaisee Intelligence (Archaeology)</option>
    <option value="general">General Storage / Backup</option>
</select>


<!-- AI PLATFORM -->
<select name="platform" style="
width:100%; padding:10px; margin-bottom:10px;
background:#111; color:#fff; border:1px solid #FFD700;
">
    <option value="chatgpt">ChatGPT</option>
    <option value="claude">Claude</option>
    <option value="gemini">Gemini</option>
    <option value="perplexity">Perplexity</option>
    <option value="manual">Manual Entry</option>
</select>


<!-- CONTENT -->
<textarea name="content" placeholder="Paste full content..." style="
width:100%; height:220px;
background:#111; color:#fff; border:1px solid #FFD700; padding:10px;
"></textarea>


<br><br>


<button class="btn-primary">Ingest</button>


</form>


<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $title    = $_POST['title'] ?? "";
    $client   = $_POST['client'] ?? "";
    $system   = $_POST['system'] ?? "";
    $platform = $_POST['platform'] ?? "";
    $content  = $_POST['content'] ?? "";


    if (!$title || !$system || !$platform || !$content) {
        echo "<p style='color:red;'>Missing required fields</p>";
        return;
    }


    // ==========================
    // SAFE VALUES
    // ==========================
    $safeTitle  = preg_replace('/[^a-zA-Z0-9_\-]/', '_', substr($title,0,50));
    $safeClient = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $client);


    $timestamp = date("Ymd_His");


    // ==========================
    // DIRECTORY ROUTING
    // ==========================
    if ($system === "legaisee") {


        if (!$safeClient) {
            echo "<p style='color:red;'>Client required for Legaisee</p>";
            return;
        }


        $targetDir = $legaiseeDir . $safeClient . "/";


    } else {
        $targetDir = $generalDir;
    }


    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);


    // ==========================
    // FILE NAME
    // ==========================
    $fileName = "{$timestamp}_{$safeTitle}.txt";
    $filePath = $targetDir . $fileName;


    // ==========================
    // STRUCTURED DATA
    // ==========================
    $data =
"TITLE: {$title}


CLIENT: {$client}


SYSTEM: {$system}


PLATFORM: {$platform}


TIMESTAMP: {$timestamp}


CONTENT:
{$content}
";


    file_put_contents($filePath, $data);


    echo "<p style='color:#00ff99;'>Saved → {$filePath}</p>";
}
?>


-File: relations_module.php 
- load:y
- shell:n
- content:Relationships
                                      test title 4-26-26                                                  Legaisee Intelligence System Map_4-23-26                                                  Legaisee Potential                                                  Search Dual Scroll and Dual Find                                                  Test Node B                                                  Test Nod A                                                  Server Buildout 1                                                  Server Buildout 2                            Add Relationship

- Internal:<?php


/* --------------------------
   ENSURE DATABASE ACCESS
--------------------------- */
if (!isset($pdo)) {
    require_once __DIR__ . "/../bootstrap.php";
}


/* --------------------------
   GET CURRENT ID
--------------------------- */
$currentId = $_GET['id'] ?? 0;


/* --------------------------
   SAVE RELATION
--------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['target_id'])) {


    $stmt = $pdo->prepare("
        INSERT INTO page_relations (source_id, target_id, relation_type, weight)
        VALUES (?, ?, ?, ?)
    ");


    $stmt->execute([
        $currentId,
        $_POST['target_id'],
        $_POST['relation_type'] ?? 'related',
        $_POST['weight'] ?? 1
    ]);
}


/* --------------------------
   LOAD OTHER NODES
--------------------------- */
$nodes = $pdo->prepare("
    SELECT id, title
    FROM page
    WHERE id != ?
    ORDER BY created DESC
    LIMIT 200
");


$nodes->execute([$currentId]);


/* --------------------------
   LOAD RELATIONSHIPS (BI-DIRECTIONAL)
--------------------------- */
$relations = $pdo->prepare("
    SELECT pr.*, p.title as target_title
    FROM page_relations pr
    JOIN page p
        ON p.id = IF(pr.source_id = ?, pr.target_id, pr.source_id)
    WHERE pr.source_id = ? OR pr.target_id = ?
");


$relations->execute([$currentId, $currentId, $currentId]);


?>


<h2>Relationships</h2>


<form method="POST">


    <select name="target_id">
        <?php foreach ($nodes as $n): ?>
            <option value="<?= $n['id'] ?>">
                <?= htmlspecialchars($n['title']) ?>
            </option>
        <?php endforeach; ?>
    </select>


    <input name="relation_type" placeholder="Relation type (e.g. derived, similar, campaign)">


    <input name="weight" placeholder="Weight (1-10)" type="number" step="0.1">


    <button class="btn btn-primary">Add Relationship</button>


</form>


<br>


<div class="card-grid">


<?php foreach ($relations as $r): ?>


    <div class="service-card">
        <h3><?= htmlspecialchars($r['target_title']) ?></h3>
        <p>Type: <?= htmlspecialchars($r['relation_type']) ?></p>
        <p>Weight: <?= $r['weight'] ?></p>
        <a href="view.php?id=<?= ($r['source_id'] == $currentId ? $r['target_id'] : $r['source_id']) ?>" class="btn btn-primary">
            Open
        </a>
    </div>


<?php endforeach; ?>


</div>


-File: report_module.php 
- load:y
- shell:n
- content:/home/carrmulti/www/www/commandcenter/clients//server_sys_build_4-21-26/raw/20260422_015914_server_sys_build_4-21-26.md
Score: 57.9
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777350997/session.json
Score: 12.57
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777354843/session.json
Score: 12.57
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777245168/session.json
Score: 12.55
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//server_sys_build_4-21-26/raw/20260422_015914_server_sys_build_4-21-26.md.json
Score: 2.14
Set A Set B


- Internal:<?php


$dir = __DIR__ . "/../normalized/";
$metaFile = $dir . "index_meta.json";


$q = strtolower(trim($_GET['q'] ?? ''));


$a = $_GET['a'] ?? '';
$b = $_GET['b'] ?? '';


$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true) ?: []
    : [];


function loadFile($dir, $file) {
    if (!$file) return "";
    $path = $dir . $file;
    return file_exists($path) ? file_get_contents($path) : "";
}


$contentA = loadFile($dir, $a);
$contentB = loadFile($dir, $b);


$results = [];


foreach ($meta as $key => $m) {


    $content = file_get_contents($dir . $key);


    $haystack = strtolower(($m['file'] ?? '') . " " . $content . " " . ($m['client'] ?? ''));


    if ($q && strpos($haystack, $q) === false) continue;


    $m['key'] = $key;
    $results[] = $m;
}


usort($results, fn($x,$y)=>($y['score'] ?? 0) <=> ($x['score'] ?? 0));


?>


<!-- LEFT COLUMN ONLY (NO WRAPPERS) -->


<form method="GET">
    <input name="q" value="<?=htmlspecialchars($q)?>" placeholder="Search">
    <input type="hidden" name="a" value="<?=htmlspecialchars($a)?>">
    <input type="hidden" name="b" value="<?=htmlspecialchars($b)?>">
    <button>Search</button>
</form>


<?php foreach ($results as $r): ?>


<?php $key = $r['key']; ?>


<div class="card">


    <div class="title"><?=htmlspecialchars($r['file'] ?? $key)?></div>


    <div class="meta">
        Score: <?=round($r['score'] ?? 0,2)?>
    </div>


    <div class="actions">


        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($key)?>&b=<?=urlencode($b)?>">
           Set A
        </a>


        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($a)?>&b=<?=urlencode($key)?>">
           Set B
        </a>


    </div>


</div>


<?php endforeach; ?>


-File: search_module.php 
- load:y
- shell:n
- content:/home/carrmulti/www/www/commandcenter/clients//server_sys_build_4-21-26/raw/20260422_015914_server_sys_build_4-21-26.md
Score: 57.9
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777350997/session.json
Score: 12.57
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777354843/session.json
Score: 12.57
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//file_intelligence/excavations/session_1777245168/session.json
Score: 12.55
Set A Set B
/home/carrmulti/www/www/commandcenter/clients//server_sys_build_4-21-26/raw/20260422_015914_server_sys_build_4-21-26.md.json
Score: 2.14
Set A Set B

- Internal:<?php


$dir = __DIR__ . "/../normalized/";
$metaFile = $dir . "index_meta.json";


$q = strtolower(trim($_GET['q'] ?? ''));


$a = $_GET['a'] ?? '';
$b = $_GET['b'] ?? '';


$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true) ?: []
    : [];


function loadFile($dir, $file) {
    if (!$file) return "";
    $path = $dir . $file;
    return file_exists($path) ? file_get_contents($path) : "";
}


$contentA = loadFile($dir, $a);
$contentB = loadFile($dir, $b);


$results = [];


foreach ($meta as $key => $m) {


    $content = file_get_contents($dir . $key);


    $haystack = strtolower(($m['file'] ?? '') . " " . $content . " " . ($m['client'] ?? ''));


    if ($q && strpos($haystack, $q) === false) continue;


    $m['key'] = $key;
    $results[] = $m;
}


usort($results, fn($x,$y)=>($y['score'] ?? 0) <=> ($x['score'] ?? 0));


?>


<!-- ONLY CONTENT, NO LAYOUT WRAPPERS -->


<form method="GET">
    <input name="q" value="<?=htmlspecialchars($q)?>" placeholder="Search">
    <input type="hidden" name="a" value="<?=htmlspecialchars($a)?>">
    <input type="hidden" name="b" value="<?=htmlspecialchars($b)?>">
    <button>Search</button>
</form>


<div class="result-list">


<?php foreach ($results as $r): ?>


<?php $key = $r['key']; ?>


<div class="card">


    <div class="title"><?=htmlspecialchars($r['file'] ?? $key)?></div>
    <div class="meta">Score: <?=round($r['score'] ?? 0,2)?></div>


    <div class="actions">


        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($key)?>&b=<?=urlencode($b)?>">
           Set A
        </a>


        <a class="link"
           href="?q=<?=urlencode($q)?>&a=<?=urlencode($a)?>&b=<?=urlencode($key)?>">
           Set B
        </a>


    </div>


</div>


<?php endforeach; ?>


</div>


<div class="pane-body" style="display:none;">
<?=htmlspecialchars($contentA)?>
<?=htmlspecialchars($contentB)?>
</div>


-File: view_module.php 
- load:n
- shell:n
- content:Record not found. 
- Internal:<?php


/* --------------------------
   ENSURE DB
--------------------------- */
if (!isset($pdo)) {
    require_once __DIR__ . "/../bootstrap.php";
}


/* --------------------------
   GET IDS
--------------------------- */
$idA = $_GET['id'] ?? 0;
$idB = $_GET['compare'] ?? null;


/* --------------------------
   LOAD RECORD A
--------------------------- */
$stmt = $pdo->prepare("SELECT * FROM page WHERE id = ?");
$stmt->execute([$idA]);
$pageA = $stmt->fetch();


$stmt = $pdo->prepare("SELECT content FROM page_content WHERE page_id = ?");
$stmt->execute([$idA]);
$contentA = $stmt->fetch();


/* --------------------------
   LOAD RECORD B (OPTIONAL)
--------------------------- */
$pageB = null;
$contentB = null;


if ($idB) {


    $stmt = $pdo->prepare("SELECT * FROM page WHERE id = ?");
    $stmt->execute([$idB]);
    $pageB = $stmt->fetch();


    $stmt = $pdo->prepare("SELECT content FROM page_content WHERE page_id = ?");
    $stmt->execute([$idB]);
    $contentB = $stmt->fetch();
}


?>


<?php if (!$pageA): ?>


    <p>Record not found.</p>


<?php else: ?>


<!-- =========================
     A/B COMPARISON VIEW
========================= -->


<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">


    <!-- COLUMN A -->
    <div class="service-card">
        <h2><?= htmlspecialchars($pageA['title']) ?> (A)</h2>


        <p>
            <?= htmlspecialchars($pageA['project']) ?> |
            <?= htmlspecialchars($pageA['platform']) ?> |
            <?= htmlspecialchars($pageA['type']) ?>
        </p>


        <hr>


        <div style="white-space:pre-wrap;">
            <?= htmlspecialchars($contentA['content'] ?? '') ?>
        </div>
    </div>


    <!-- COLUMN B -->
    <div class="service-card">


        <?php if ($pageB): ?>


            <h2><?= htmlspecialchars($pageB['title']) ?> (B)</h2>


            <p>
                <?= htmlspecialchars($pageB['project']) ?> |
                <?= htmlspecialchars($pageB['platform']) ?> |
                <?= htmlspecialchars($pageB['type']) ?>
            </p>


            <hr>


            <div style="white-space:pre-wrap;">
                <?= htmlspecialchars($contentB['content'] ?? '') ?>
            </div>


        <?php else: ?>


            <h2>Comparison (B)</h2>
            <p>No comparison selected.</p>


        <?php endif; ?>


    </div>


</div>


<br><br>


<!-- =========================
     RELATIONSHIPS (ATTACHED TO A)
========================= -->


<?php include __DIR__ . "/relations_module.php"; ?>


<?php endif; ?>


-File: 
- load:
- shell:
- content:
- Internal:

-File: 
- load:
- shell:
- content:
- Internal:

-File: 
- load:
- shell:
- content:
- Internal:

-File: 
- load:
- shell:
- content:
- Internal:
