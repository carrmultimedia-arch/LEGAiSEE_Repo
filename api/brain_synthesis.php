<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$data = $input['data'] ?? [];

if(!$data){
    echo json_encode(["error"=>"no model data"]);
    exit;
}

/* WEIGHTING LOGIC (SIMPLIFIED v1) */
$weights = [
    "openai"=>0.4,
    "claude"=>0.35,
    "gemini"=>0.25
];

$synthesis = [
    "core_insight"=>"",
    "confidence"=>0,
    "contradictions"=>[],
    "model_summary"=>[]
];

$totalConfidence = 0;

foreach($data as $model=>$output){

    $synthesis["model_summary"][$model] = $output;

    $confidence = rand(60,95); // placeholder scoring

    $totalConfidence += $confidence * ($weights[$model] ?? 0);

    if(strpos($output, "ERROR") !== false){
        $synthesis["contradictions"][] = $model;
    }
}

$synthesis["confidence"] = round($totalConfidence);

$synthesis["core_insight"] =
    "Merged intelligence across models with weighted consensus scoring.";

echo json_encode($synthesis);