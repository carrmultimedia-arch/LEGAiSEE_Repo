<?php
header('Content-Type: application/json');

session_start();

$brain_id = $_GET['brain_id'] ?? $_SESSION['brain_id'] ?? '';

if(!$brain_id){
    echo json_encode(["error"=>"brain_id not found in session or input"]);
    exit;
}

$file = __DIR__."/../data/brains/".$brain_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"brain not found"]);
    exit;
}

$session = json_decode(file_get_contents($file), true);

/* SIMULATED FILE INPUT */
$content = file_get_contents(__DIR__."/../normalized/".$session['file']);

$step = count($session['steps']) + 1;

/* MODEL PASS SIMULATION */
$pass = match(true){
    $step === 1 => "STRUCTURE ANALYSIS",
    $step === 2 => "SEMANTIC EXTRACTION",
    $step === 3 => "INTENT MODELING",
    $step === 4 => "CONTRADICTION SCAN",
    default => "FINAL SYNTHESIS"
};

$chunk = [
    "step"=>$step,
    "pass"=>$pass,
    "node_id"=>$session['node_id'] ?? null,
    "insight"=>"[$pass] extracted patterns from document segment",
    "signals"=>[
        "density"=>rand(1,100),
        "confidence"=>rand(60,99),
        "risk"=>rand(1,10)
    ],
    "timestamp"=>date("H:i:s")
];

$session['steps'][] = $chunk;

/* persist brain state */
file_put_contents($file, json_encode($session, JSON_PRETTY_PRINT));

echo json_encode($chunk);