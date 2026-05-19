<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$agency_id = $input['agency_id'] ?? '';
$case = $input['case'] ?? '';

$roles = [
    "analyzer",
    "contradiction_detector",
    "trend_mapper",
    "risk_model",
    "synthesis_core"
];

$agents = [];

foreach($roles as $role){

    $agents[] = [
        "id"=>uniqid("agent_"),
        "role"=>$role,
        "case"=>$case,
        "status"=>"idle",
        "last_run"=>null,
        "memory"=>[]
    ];
}

echo json_encode([
    "case"=>$case,
    "agents"=>$agents
]);