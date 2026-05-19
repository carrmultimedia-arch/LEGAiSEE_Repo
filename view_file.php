<?php
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