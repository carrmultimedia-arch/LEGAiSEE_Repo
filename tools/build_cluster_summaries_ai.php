<?php

require_once __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../config.php";

echo "Running AI cluster summaries...\n";

/* --------------------------
   OPENAI CALL
--------------------------- */
function callLLM($prompt) {

    $ch = curl_init("https://api.openai.com/v1/chat/completions");

    $data = [
        "model" => "gpt-5.3",
        "messages" => [
            ["role" => "system", "content" =>
                "You are a business intelligence analyst. 
                Produce concise, high-value summaries of clustered data."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.4
    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer " . OPENAI_API_KEY
        ],
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);

    $response = curl_exec($ch);

    if (!$response) {
        return "LLM request failed.";
    }

    $json = json_decode($response, true);

    return $json['choices'][0]['message']['content'] ?? "No output.";
}

/* --------------------------
   LOAD CLUSTERS
--------------------------- */
$stmt = $pdo->query("SELECT id FROM clusters");
$clusterIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

/* --------------------------
   PROCESS EACH CLUSTER
--------------------------- */
foreach ($clusterIds as $cid) {

    $stmt = $pdo->prepare("
        SELECT title, project, platform
        FROM page
        WHERE cluster_id = ?
        LIMIT 50
    ");
    $stmt->execute([$cid]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$rows) continue;

    /* --------------------------
       BUILD PROMPT
    --------------------------- */
    $lines = [];

    foreach ($rows as $r) {
        $lines[] = "{$r['title']} | {$r['project']} | {$r['platform']}";
    }

    $prompt = "
You are analyzing a cluster of business intelligence records.

DATA:
" . implode("\n", $lines) . "

TASK:
1. Identify the core theme of this cluster
2. Explain what type of work or activity it represents
3. Identify patterns or repeated strategies
4. Describe business significance

OUTPUT:
Write a tight, high-value executive summary (4–6 sentences max).
No fluff. No generic language. No bullet points.
";

    echo "Cluster $cid → calling LLM...\n";

    $summary = callLLM($prompt);

    /* --------------------------
       SAVE
    --------------------------- */
    $stmt = $pdo->prepare("
        UPDATE clusters
        SET summary = ?
        WHERE id = ?
    ");

    $stmt->execute([$summary, $cid]);

    echo "Cluster $cid updated\n";

    sleep(1); // prevent rate limits
}

echo "Done.\n";