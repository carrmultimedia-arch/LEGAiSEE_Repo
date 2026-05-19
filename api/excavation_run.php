<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? null;

if(!$file){
    echo json_encode(["error"=>"missing file"]);
    exit;
}

/* CALL CORE ENGINE */
$response = file_get_contents("http://localhost/api/excavate.php", false, stream_context_create([
    "http" => [
        "method" => "POST",
        "header" => "Content-Type: application/json",
        "content" => json_encode(["file"=>$file])
    ]
]));

echo $response;