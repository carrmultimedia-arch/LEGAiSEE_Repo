<?php

require_once __DIR__ . '/cluster_engine.php';
require_once __DIR__ . '/reasoning_engine.php';
require_once __DIR__ . '/recommendation_engine.php';

/*
================================================
PATH → CASE RESOLUTION
================================================
*/

function extractCaseIdFromPath($path){

    preg_match('/cases\/.*?\/cases\/(case_\d+)/', $path, $m);

    return $m[1] ?? null;
}

/*
================================================
CLUSTER ADAPTER
================================================
*/

function clusterNodesPath($path){

    $case_id = basename(dirname(dirname($path)));

    clusterNodes($case_id);
}

/*
================================================
INSIGHT ADAPTER
================================================
*/

function generateInsightsPath($path){

    $case_id = basename(dirname(dirname($path)));

    generateInsights($case_id);
}

/*
================================================
RECOMMENDATION ADAPTER
================================================
*/

function generateRecommendationsPath($path){

    require_once __DIR__ . '/recommendation_engine.php';

    // extract case folder safely
    $caseDir = $path;

    return generateRecommendationsFromPath($caseDir);
}

