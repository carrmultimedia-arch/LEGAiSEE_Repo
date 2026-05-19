<?php

function generateInsights($case_id){

    $clusterFile = __DIR__ . "/../data/cases/$case_id/clusters.json";
    $insightFile = __DIR__ . "/../data/cases/$case_id/insights.json";

    if(!file_exists($clusterFile)) return;

    $clusters = json_decode(file_get_contents($clusterFile), true);

    $insights = [];

    /*
    ====================================================
    RULE 1: RISK + GROWTH = STRATEGIC CONFLICT
    ====================================================
    */

    if(isset($clusters['market_risk']) && isset($clusters['growth'])){

        $insights[] = [
            "type" => "risk_vs_growth",
            "summary" => "Growth opportunities are directly tied to identified market risks",
            "clusters_involved" => ["market_risk", "growth"],
            "confidence" => "high",
            "created_at" => date("c")
        ];
    }

    /*
    ====================================================
    RULE 2: OPPORTUNITY + LOW RISK (future)
    ====================================================
    */

    if(isset($clusters['opportunity']) && !isset($clusters['market_risk'])){

        $insights[] = [
            "type" => "clean_opportunity",
            "summary" => "Opportunity detected with minimal associated risk",
            "clusters_involved" => ["opportunity"],
            "confidence" => "medium",
            "created_at" => date("c")
        ];
    }

    file_put_contents($insightFile, json_encode($insights, JSON_PRETTY_PRINT));
}