<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/_response.php';

$case_id = intval($_GET['case_id'] ?? 1);

$path = __DIR__ . "/../../data/network/net_case_$case_id.json";

$graph = json_decode(file_get_contents($path), true);

$nodes = $graph['nodes'] ?? [];

usort($nodes, function($a, $b){
    return ($b['strength'] ?? 0) <=> ($a['strength'] ?? 0);
});

json_response([
    "top_nodes" => array_slice($nodes, 0, 10)
]);