<?php
header('Content-Type: application/json');

$network_id = $_POST['network_id'] ?? '';

$file = __DIR__ . "/../../data/network/" . $network_id . ".json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

if(!file_exists($file)){
    echo json_encode(["error"=>"network not found"]);
    exit;
}

$network = json_decode(file_get_contents($file), true);

$newCases = [];

foreach($network['nodes'] as $n){

    if(($n['type'] ?? '') === 'anomaly' && ($n['strength'] ?? 0) > 70){

        $caseId = uniqid("auto_case_");

        $case = [
            "id"=>$caseId,
            "source_node"=>$n['id'],
            "reason"=>"High anomaly trigger",
            "created_at"=>date("Y-m-d H:i:s"),
            "status"=>"generated"
        ];

        $newCases[] = $case;
    }
}

echo json_encode([
    "generated_cases"=>$newCases,
    "count"=>count($newCases)
]);
echo json_encode($response);
exit;
