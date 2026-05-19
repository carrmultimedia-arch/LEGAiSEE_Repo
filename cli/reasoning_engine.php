#!/usr/local/bin/php.cli
<?php

$basePath = realpath(__DIR__ . "/..");

$queueFile = $basePath . "/data/events/event_queue.json";
$chainFile = $basePath . "/data/chains/chain_templates.json";
$logDir    = $basePath . "/data/reasoning_log/";

if (!file_exists($queueFile) || !file_exists($chainFile)) {
    echo "missing core files\n";
    exit;
}

$events = json_decode(file_get_contents($queueFile), true) ?: [];
$chains = json_decode(file_get_contents($chainFile), true) ?: [];

if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

/**
 * PROCESS EVENTS
 */
foreach ($events as &$event) {

    if (($event['status'] ?? '') !== 'pending') {
        continue;
    }

    $type = $event['type'] ?? null;
    $networkId = $event['network_id'] ?? null;

    if (!$type || !isset($chains[$type])) {
        $event['status'] = 'invalid_or_no_chain';
        continue;
    }

$chainSet = $chains[$type];

$goalContext = $event['goal_context'] ?? null;
$goalBias = 1.0;

if ($goalContext && isset($goalContext['alignment_score'])) {
    $goalBias += ($goalContext['alignment_score'] / 10);
}

    $bestDecision = null;
    $bestScore = -INF;
    $bestTrace = [];
    $bestChainId = null;

    /**
     * RUN MULTIPLE CHAINS (COMPETITION LAYER)
     */
    foreach ($chainSet as $chainDef) {

        $chainId = $chainDef['chain_id'] ?? 'unknown';
        $steps = $chainDef['steps'] ?? [];

        $stateScore = 0;
        $riskScore = 0;
        $trace = [];

        foreach ($steps as $step) {

            $action = $step['action'] ?? 'noop';
            $weight = max(1, (int)($step['weight'] ?? 1));

            for ($i = 0; $i < $weight; $i++) {

                switch ($action) {

                    case "analyze_node_strength":
                        $stateScore += 10;
                        $trace[] = "strength analyzed";
                        break;

                    case "evaluate_network_impact":
                        $stateScore += 15;
                        $trace[] = "impact evaluated";
                        break;

                    case "determine_risk_state":
                        $riskScore += 20;
                        $trace[] = "risk computed";
                        break;

                    case "cluster_anomaly_check":
                        $riskScore += 25;
                        $trace[] = "anomaly cluster checked";
                        break;

                    case "compare_historical_anomalies":
                        $riskScore += 10;
                        $trace[] = "history compared";
                        break;

                    case "risk_classification":
                        $trace[] = "risk classified";
                        break;

                    case "emit_decision_event":
                        $trace[] = "decision stage reached";
                        break;
                }
            }
        }

        /**
         * SCORING FUNCTION (COMPETITION CORE)
         */
        $$score = (($stateScore * 1.0) - ($riskScore * 1.2)) * $goalBias;

        if ($score > $bestScore) {

            $bestScore = $score;
            $bestChainId = $chainId;
            $bestTrace = $trace;

            if ($riskScore >= 50) {
                $bestDecision = "ESCALATE";
            } elseif ($stateScore >= 25) {
                $bestDecision = "PROCEED";
            } else {
                $bestDecision = "MONITOR";
            }
        }
    }

    /**
     * FINAL OUTPUT (WINNING CHAIN ONLY)
     */
    $result = [
        "event_id" => $event['id'],
        "network_id" => $networkId,
        "event_type" => $type,
        "winning_chain" => $bestChainId,
        "decision" => $bestDecision,
        "score" => $bestScore,
        "trace" => $bestTrace,
        "timestamp" => date("Y-m-d H:i:s")
    ];

    file_put_contents(
        $logDir . "multi_chain_" . time() . "_" . uniqid() . ".json",
        json_encode($result, JSON_PRETTY_PRINT)
    );

    $event['status'] = 'processed_multi_chain';
}

file_put_contents($queueFile, json_encode($events, JSON_PRETTY_PRINT));

echo "multi-chain reasoning complete\n";