<?php
header('Content-Type: application/json');

$network_id = "net_69eee12e374d30_99173905";

$input = json_decode(file_get_contents("php://input"), true);

$query = $input['query'] ?? '';

if (!$query) {
    echo json_encode(["error"=>"no query"]);
    exit;
}

$platforms = ["chatgpt","claude","gemini"];

$results = [];

foreach ($platforms as $p) {

    $response = "AI {$p} analysis for: {$query}";

    $strength = strlen($response) / 10;

    $type = (stripos($response, 'risk') !== false) ? 'anomaly' : 'signal';

    /* PUSH TO NETWORK */
    $url = "http://" . $_SERVER['HTTP_HOST'] . "/commandcenter/api/v8/network_add_node.php";

    $postData = http_build_query([
        "network_id" => $network_id,
        "type" => $type,
        "strength" => $strength
    ]);

    file_get_contents($url, false, stream_context_create([
        "http" => [
            "method" => "POST",
            "header" => "Content-type: application/x-www-form-urlencoded",
            "content" => $postData
        ]
    ]));

    $results[] = [
        "platform"=>$p,
        "status"=>"node_created"
    ];
}

echo json_encode([
    "success"=>true,
    "results"=>$results
]);