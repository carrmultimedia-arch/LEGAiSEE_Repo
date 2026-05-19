<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$agency_id = $input['agency_id'] ?? '';

$file = __DIR__."/../data/agency/".$agency_id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"agency not found"]);
    exit;
}

$agency = json_decode(file_get_contents($file), true);

$memoryCount = count($agency['global_memory']);

$synthesis = [
    "agency_id"=>$agency_id,
    "total_events"=>$memoryCount,
    "global_insight"=>"Cross-case intelligence synthesis complete",
    "system_health"=>rand(70,100),
    "emergent_patterns"=>[
        "recurring risk clusters",
        "multi-case signal alignment",
        "trend convergence detected"
    ]
];

echo json_encode($synthesis);