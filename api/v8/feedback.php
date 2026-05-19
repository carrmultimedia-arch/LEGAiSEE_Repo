<?php
header('Content-Type: application/json');

$pattern = $_POST['pattern'] ?? '';
$useful = $_POST['useful'] ?? 0;

if (!$pattern) {
    echo json_encode(["error"=>"missing pattern"]);
    exit;
}
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';
$ch = curl_init("http://localhost/commandcenter/api/v8/learn.php");

$data = [
    "pattern"=>$pattern,
    "outcome"=>$useful ? "useful" : "useless"
];

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

echo $response;