#!/usr/local/bin/php.cli
<?php

$queueFile = __DIR__ . "/../data/events/event_queue.json";

if (!file_exists($queueFile)) {
    echo "no queue\n";
    exit;
}

$events = json_decode(file_get_contents($queueFile), true);
if (!$events) $events = [];

$processed = [];

foreach ($events as &$event) {

    if (($event['status'] ?? '') !== "pending") continue;

    $type = $event['type'];
    $network_id = $event['network_id'];

    $log = __DIR__ . "/../data/event_log/";

    if (!is_dir($log)) mkdir($log, 0777, true);

    $result = [
        "event_id"=>$event['id'],
        "type"=>$type,
        "network_id"=>$network_id,
        "processed_at"=>date("Y-m-d H:i:s")
    ];

    /* SIMPLE EVENT ROUTING */
    switch ($type) {

        case "node_added":
            $result["action"] = "recalculate_network";
            break;

        case "anomaly_detected":
            $result["action"] = "trigger_case_generation";
            break;

        case "threshold_breach":
            $result["action"] = "generate_alert";
            break;

        default:
            $result["action"] = "log_only";
            break;
    }

    file_put_contents(
        $log . "event_" . time() . ".json",
        json_encode($result, JSON_PRETTY_PRINT)
    );

    $event['status'] = "processed";
    $processed[] = $event;
}

/* SAVE UPDATED QUEUE */
file_put_contents($queueFile, json_encode($events, JSON_PRETTY_PRINT));

echo "processed: " . count($processed) . "\n";