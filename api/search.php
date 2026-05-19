<?php

header("Content-Type: application/json");

$dir = __DIR__ . "/../normalized/";
$metaFile = $dir . "index_meta.json";

$q = strtolower($_GET['q'] ?? '');

$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true) ?: []
    : [];

$out = [];

foreach($meta as $key=>$m){

    $content = file_exists($dir.$key) ? file_get_contents($dir.$key) : "";

    $hay = strtolower(($m['file'] ?? '')." ".$content);

    if($q && strpos($hay,$q) === false) continue;

    $out[] = [
        "key"=>$key,
        "file"=>$m['file'] ?? $key,
        "score"=>$m['score'] ?? 0
    ];
}

usort($out, fn($a,$b)=>$b['score'] <=> $a['score']);

echo json_encode(["results"=>$out]);