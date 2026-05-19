<?php

require_once __DIR__ . '/semantic_cluster_engine.php';
require_once __DIR__ . '/memory_evolution_engine.php';
require_once __DIR__ . '/system_insight_engine.php';
require_once __DIR__ . '/cross_case_engine.php';
require_once __DIR__ . '/portfolio_engine.php';

/*
================================================
EXECUTIVE DASHBOARD ENGINE
================================================
*/

function buildExecutiveDashboard(){

    $cases = loadAllCases();

    $allNodes = [];

    foreach($cases as $case){
        $allNodes = array_merge($allNodes, $case['nodes'] ?? []);
    }

    $clusters = buildSemanticClusters($allNodes);
    $memory = buildMemoryEvolution();
    $insights = generateSystemInsights();
    $cross = buildCrossCaseClusters();

    $dashboard = [
        "summary" => [
            "total_nodes" => count($allNodes),
            "clusters" => array_keys($clusters),
            "memory_trend" => $memory['trend'] ?? "unknown"
        ],
        "insights" => $insights,
        "cross_case_signals" => $cross,
        "memory_evolution" => $memory
    ];

    file_put_contents(
        __DIR__ . "/../data/portfolio/executive_dashboard.json",
        json_encode($dashboard, JSON_PRETTY_PRINT)
    );

    return $dashboard;
}