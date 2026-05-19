<?php

$client = $_GET['client'] ?? null;
$session_id = $_GET['session'] ?? null;
require_once __DIR__ . '/lib/semantic_diff_engine.php';
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