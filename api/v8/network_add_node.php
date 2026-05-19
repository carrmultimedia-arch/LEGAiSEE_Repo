<?php

header('Content-Type: application/json');

$client_id = $_POST['client_id'] ?? '';
$case_id   = $_POST['case_id'] ?? '';
$content   = $_POST['content'] ?? '';

file_put_contents(
"/home/carrmulti/www/www/commandcenter/debug_trace.log",
json_encode([
    "time" => date("c"),
    "client_id" => $client_id ?? null,
    "case_id" => $case_id ?? null,
    "content" => $content ?? null,
    "target_path" => "/home/carrmulti/www/www/commandcenter/data/clients/$client_id/cases/$case_id/tasks/queue.json"
]) . PHP_EOL,
FILE_APPEND
);

if(!$client_id || !$case_id || !$content){
    echo json_encode(["status"=>"error","message"=>"missing data"]);
    exit;
}

$queueFile = "/home/carrmulti/www/www/commandcenter/data/clients/$client_id/cases/$case_id/tasks/queue.json";

$queueFile = "/home/carrmulti/www/www/commandcenter/data/clients/$client_id/cases/$case_id/tasks/queue.json";

/* HARD CHECK */
if(!file_exists(dirname($queueFile))){
    mkdir(dirname($queueFile), 0777, true);
}

$queue = [];

if(file_exists($queueFile)){
    $queue = json_decode(file_get_contents($queueFile), true);
}

if(!is_array($queue)){
    $queue = [];
}

$task = [
    "type" => "add_node",
    "content" => $content,
    "time" => date("c")
];

$queue[] = $task;

/* HARD WRITE CHECK */
$write_result = file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));

file_put_contents(
"/home/carrmulti/www/www/commandcenter/debug_write.log",
json_encode([
    "file" => $queueFile,
    "write_result" => $write_result,
    "final_queue_size" => count($queue),
    "task" => $task
]) . PHP_EOL,
FILE_APPEND
);

echo json_encode([
    "status" => "ok",
    "written" => $write_result !== false,
    "queue_count" => count($queue)
]);

if(file_exists($queueFile)){
    $queue = json_decode(file_get_contents($queueFile), true);
}

$task = [
    "type" => "add_node",
    "content" => $content,
    "time" => date("c")
];

$queue[] = $task;

file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));

echo json_encode([
    "status"=>"ok",
    "queue_count"=>count($queue)
]);