<?php
require_once "db.php";

$workspaceId = $_GET['workspace_id'] ?? null;
require_once __DIR__ . '/lib/semantic_diff_engine.php';
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