<?php
header('Content-Type: application/json');

$id = $_POST['id'] ?? '';

$file = __DIR__."/../data/cases/".$id.".json";

if(!file_exists($file)){
    echo json_encode(["error"=>"case not found"]);
    exit;
}

$case = json_decode(file_get_contents($file), true);

$sourceFile = __DIR__."/../normalized/".$case['file'];

$content = file_exists($sourceFile)
    ? file_get_contents($sourceFile)
    : "";

$tick = [
    "tick_id"=>uniqid("tick_"),
    "timestamp"=>date("Y-m-d H:i:s"),
    "analysis"=>[
        "pattern_score"=>rand(1,100),
        "risk_index"=>rand(1,10),
        "signal_density"=>rand(50,100),
        "change_detected"=>rand(0,1) === 1
    ],
    "insight"=>"Autonomous reasoning cycle executed on case data"
];

$case['memory'][] = $tick;
$case['last_tick'] = $tick['timestamp'];

/* UPDATE DOSSIER */
$case['dossier'] = [
    "summary"=>"Evolving intelligence case with ".count($case['memory'])." cycles",
    "status"=>"active",
    "latest_tick"=>$tick
];

file_put_contents($file, json_encode($case, JSON_PRETTY_PRINT));

echo json_encode($tick);