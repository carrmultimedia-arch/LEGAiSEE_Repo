<?php
require_once "db.php";
/*
======================================================
LEGAiSEE EMBEDDING GENERATOR
- Converts page content → OpenAI vector embeddings
======================================================
*/
$OPENAI_API_KEY = require '/home/carrmulti/private/openai_key.php';
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