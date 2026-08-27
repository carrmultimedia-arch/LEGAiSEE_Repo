<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";
require_once __DIR__ . '/lib/semantic_diff_engine.php';
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