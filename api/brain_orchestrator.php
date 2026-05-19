<?php
header('Content-Type: application/json');

require_once "model_router.php";

$input = json_decode(file_get_contents("php://input"), true);

$file = $input['file'] ?? '';

$path = __DIR__ . "/../normalized/" . $file;

if(!file_exists($path)){
    echo json_encode(["error"=>"file not found"]);
    exit;
}

$content = file_get_contents($path);

/* STEP 1: INITIAL PROMPT BUILD */
$prompt = "
Analyze this document for intelligence extraction:

$content

Return structured insights: themes, risks, intent, anomalies.
";

/* STEP 2: MULTI-MODEL EXECUTION */
$responses = route_models($prompt);

/* STEP 3: RETURN RAW MULTI-MODEL OUTPUT */
echo json_encode([
    "file"=>$file,
    "raw"=>$responses
]);