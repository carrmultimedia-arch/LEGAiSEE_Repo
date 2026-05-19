<?php

/*
|--------------------------------------------------------------------------
| CLUSTER INTELLIGENCE ENGINE
|--------------------------------------------------------------------------
| Groups graph nodes into meaningful business intelligence clusters
*/

function clusterSimilarity($a, $b) {

    $a = strtolower($a);
    $b = strtolower($b);

    similar_text($a, $b, $percent);

    return $percent;
}

function detectClusters($network_file) {

    if (!file_exists($network_file)) {
        return [];
    }

    $data = json_decode(file_get_contents($network_file), true);

    $nodes = $data['nodes'] ?? [];
    $edges = $data['edges'] ?? [];

    $clusters = [];

    /*
    |--------------------------------------------------------------------------
    | STEP 1: INITIAL SEEDING
    |--------------------------------------------------------------------------
    */

    foreach ($nodes as $node) {

        $assigned = false;

        foreach ($clusters as &$cluster) {

            $score = clusterSimilarity(
                $node['content'],
                $cluster['label_seed']
            );

            if ($score > 60) {

                $cluster['nodes'][] = $node;
                $cluster['strength'] += $node['strength'];
                $assigned = true;
                break;
            }
        }

        if (!$assigned) {

            $clusters[] = [
                "label_seed" => $node['content'],
                "nodes" => [$node],
                "strength" => $node['strength']
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2: NAME CLUSTERS
    |--------------------------------------------------------------------------
    */

    foreach ($clusters as &$cluster) {

        $keywords = [];

        foreach ($cluster['nodes'] as $node) {

            $words = explode(" ", strtolower($node['content']));

            foreach ($words as $w) {
                if (strlen($w) > 4) {
                    $keywords[$w] = ($keywords[$w] ?? 0) + 1;
                }
            }
        }

        arsort($keywords);

        $cluster['label'] = array_key_first($keywords) ?? "Unknown Cluster";
        $cluster['size'] = count($cluster['nodes']);
    }

    return $clusters;
}