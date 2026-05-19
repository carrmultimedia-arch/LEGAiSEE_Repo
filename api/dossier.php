<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$file = $input['file'] ?? '';

$cache = __DIR__."/intel_cache.json";

if(!file_exists($cache)){
    echo json_encode(["error"=>"no intelligence"]);
    exit;
}

$data = json_decode(file_get_contents($cache), true);

/* DOSSIER FORMAT */
$dossier = [
    "FILE DOSSIER"=>$file,
    "EXECUTIVE SUMMARY"=>$data['core_insight'],
    "CONFIDENCE"=>$data['confidence'],
    "KEY THEMES"=>$data['themes'],
    "MODEL BREAKDOWN"=>$data['models'],
    "CLASSIFICATION"=>"LEGAISEE INTELLIGENCE NODE"
];

echo json_encode($dossier);