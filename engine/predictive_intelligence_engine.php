<?php

require_once __DIR__ . '/portfolio_engine.php';
require_once __DIR__ . '/semantic_cluster_engine.php';

/*
================================================
CROSS-CASE PREDICTIVE INTELLIGENCE ENGINE v2
Portfolio-level forecasting
================================================
*/

function buildPredictiveInsights(){

    $cases = loadAllCases();

    $allNodes = [];

    foreach($cases as $case){
        $allNodes = array_merge($allNodes, $case['nodes'] ?? []);
    }

    /*
    ====================================================
    STEP 1: SEMANTIC CLUSTERING ACROSS ALL CASES
    ====================================================
    */

    $clusters = buildSemanticClusters($allNodes);

    $counts = [];

    foreach($clusters as $type => $nodes){
        $counts[$type] = count($nodes);
    }

    /*
    ====================================================
    STEP 2: NORMALIZE + ANALYZE DISTRIBUTION
    ====================================================
    */

    $total = array_sum($counts);

    $distribution = [];

    foreach($counts as $type => $count){

        $distribution[$type] = ($total > 0)
            ? round(($count / $total) * 100, 2)
            : 0;
    }

    /*
    ====================================================
    STEP 3: FORECAST LOGIC (CROSS-CASE)
    ====================================================
    */

    $forecast = [];

    // RISK DOMINANCE
    if(($distribution['risk_signals'] ?? 0) > 40){

        $forecast[] = [
            "type" => "portfolio_risk_forecast",
            "prediction" => "Risk signals dominate across portfolio",
            "likelihood" => "high",
            "impact" => "increased probability of negative performance",
            "action" => "prioritize mitigation strategies across clients",
            "confidence_score" => $distribution['risk_signals'],
            "created_at" => date("c")
        ];
    }

    // GROWTH DOMINANCE
    if(($distribution['growth_signals'] ?? 0) > 40){

        $forecast[] = [
            "type" => "portfolio_growth_forecast",
            "prediction" => "Growth signals dominate across portfolio",
            "likelihood" => "high",
            "impact" => "high expansion opportunity",
            "action" => "allocate resources to scaling initiatives",
            "confidence_score" => $distribution['growth_signals'],
            "created_at" => date("c")
        ];
    }

    // ENGAGEMENT DECLINE SIGNAL
    if(($distribution['audience_performance'] ?? 0) > 30){

        $forecast[] = [
            "type" => "engagement_volatility_forecast",
            "prediction" => "Audience performance signals are elevated",
            "likelihood" => "medium",
            "impact" => "unstable engagement trends expected",
            "action" => "audit content and distribution channels",
            "confidence_score" => $distribution['audience_performance'],
            "created_at" => date("c")
        ];
    }

    /*
    ====================================================
    STEP 4: MIXED SIGNAL DETECTION
    ====================================================
    */

    if(
        ($distribution['risk_signals'] ?? 0) > 20 &&
        ($distribution['growth_signals'] ?? 0) > 20
    ){

        $forecast[] = [
            "type" => "conflict_forecast",
            "prediction" => "Growth and risk signals are both elevated",
            "likelihood" => "high",
            "impact" => "volatile outcomes across cases",
            "action" => "balance aggressive growth with risk controls",
            "confidence_score" => round(
                ($distribution['risk_signals'] + $distribution['growth_signals']) / 2, 2
            ),
            "created_at" => date("c")
        ];
    }

    /*
    ====================================================
    STEP 5: FALLBACK (NEVER EMPTY)
    ====================================================
    */

    if(empty($forecast)){

        $forecast[] = [
            "type" => "stable_portfolio_forecast",
            "prediction" => "No dominant pattern detected across portfolio",
            "likelihood" => "low",
            "impact" => "stable system state",
            "action" => "continue monitoring signals",
            "confidence_score" => 0,
            "created_at" => date("c")
        ];
    }

    /*
    ====================================================
    STEP 6: GUARANTEED WRITE
    ====================================================
    */

    $dir = __DIR__ . "/../data/portfolio/";

    if(!is_dir($dir)){
        mkdir($dir, 0777, true);
    }

    $file = $dir . "predictive_insights.json";

    $written = file_put_contents(
        $file,
        json_encode([
            "distribution" => $distribution,
            "forecasts" => $forecast
        ], JSON_PRETTY_PRINT)
    );

    file_put_contents(
        $dir . "_debug_predictive.log",
        json_encode([
            "written_bytes" => $written,
            "total_nodes" => count($allNodes),
            "distribution" => $distribution,
            "time" => date("c")
        ], JSON_PRETTY_PRINT)
    );

    return $forecast;
}