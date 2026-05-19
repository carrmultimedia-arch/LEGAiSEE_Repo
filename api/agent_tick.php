<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$agent = $input['agent'] ?? null;

if(!$agent){
    echo json_encode(["error"=>"missing agent"]);
    exit;
}

$role = $agent['role'];

$logic = match($role){

    "analyzer" => "Extracting structural meaning from dataset",
    "contradiction_detector" => "Scanning for inconsistencies across signals",
    "trend_mapper" => "Identifying directional patterns over time",
    "risk_model" => "Evaluating instability factors",
    "synthesis_core" => "Merging all agent outputs into unified insight",
    default => "Idle reasoning state"
};

$output = [
    "agent_id"=>$agent['id'],
    "role"=>$role,
    "insight"=>$logic,
    "score"=>rand(50,100),
    "timestamp"=>date("H:i:s")
];

echo json_encode($output);