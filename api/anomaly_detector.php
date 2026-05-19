<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$data = $input['data'] ?? [];

$score = rand(1,100);

/*
In real version:
- statistical deviation detection
- semantic drift detection
- contradiction clustering
*/

$anomaly = $score > 70;

if($anomaly){

    $event = [
        "type"=>"anomaly_detected",
        "severity"=>$score,
        "timestamp"=>date("Y-m-d H:i:s"),
        "action"=>"spawn_new_node"
    ];

} else {

    $event = [
        "type"=>"normal_flow",
        "severity"=>$score,
        "timestamp"=>date("Y-m-d H:i:s")
    ];
}

echo json_encode($event);