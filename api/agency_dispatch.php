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

/* simulate case dispatch */
$agency['global_memory'][] = [
    "event"=>"dispatch_cycle",
    "timestamp"=>date("Y-m-d H:i:s"),
    "status"=>"agents activated across system"
];

file_put_contents($file, json_encode($agency, JSON_PRETTY_PRINT));

echo json_encode([
    "status"=>"dispatched",
    "agency"=>$agency_id
]);