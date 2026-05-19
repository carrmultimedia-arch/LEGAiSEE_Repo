<?php

header("Content-Type: application/json");

$dir = __DIR__ . "/../normalized/";

$file = basename($_GET['file'] ?? '');
$path = $dir . $file;

if(!file_exists($path)){
    echo json_encode(["error"=>"not found"]);
    exit;
}

$content = file_get_contents($path);
$lines = explode("\n",$content);

echo json_encode([
    "file"=>$file,
    "size"=>strlen($content),
    "lines"=>count($lines),
    "excerpt"=>implode("\n", array_slice($lines,0,10)),
    "content"=>$content
]);