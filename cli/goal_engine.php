#!/usr/local/bin/php.cli
<?php

$base = realpath(__DIR__ . "/..");

$goalFile = $base . "/data/goals/goals.json";
$eventFile = $base . "/data/events/event_queue.json";
$logDir = $base . "/data/goal_log/";

if (!file_exists($goalFile) || !file_exists($eventFile)) {
    echo "missing core files\n";
    exit;
}

$goals = json_decode(file_get_contents($goalFile), true) ?: [];
$events = json_decode(file_get_contents($eventFile), true) ?: [];

if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

/**
 * STEP 1: SCORE EVENTS AGAINST GOALS
 */
foreach ($events as &$event) {

    if (($event['status'] ?? '') !== 'pending') continue;

    $type = $event['type'] ?? '';
    $networkId = $event['network_id'] ?? '';

    $bestGoal = null;
    $bestAlignment = -INF;

    foreach ($goals as $goal) {

        if (($goal['status'] ?? '') !== 'active') continue;

        $alignment = 0;

        /**
         * SIMPLE ALIGNMENT MODEL (deterministic heuristic scoring)
         */
        if ($goal['goal_id'] === 'network_stability') {

            if ($type === 'node_added') {
                $alignment += 5;
            }

            if ($type === 'anomaly_detected') {
                $alignment -= 3;
            }
        }

        if ($goal['goal_id'] === 'anomaly_detection') {

            if ($type === 'anomaly_detected') {
                $alignment += 10;
            }

            if ($type === 'node_added') {
                $alignment += 2;
            }
        }

        if ($alignment > $bestAlignment) {
            $bestAlignment = $alignment;
            $bestGoal = $goal;
        }
    }

    /**
     * ATTACH GOAL CONTEXT TO EVENT
     */
    $event['goal_context'] = [
        "goal_id" => $bestGoal['goal_id'] ?? null,
        "alignment_score" => $bestAlignment
    ];
}

/**
 * STEP 2: WRITE GOAL-AUGMENTED EVENTS
 */
file_put_contents(
    $eventFile,
    json_encode($events, JSON_PRETTY_PRINT)
);

echo "goal alignment complete\n";