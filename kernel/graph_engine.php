<?php

function graph_get_data(PDO $pdo): array {

    /*
    |--------------------------------------------------------------------------
    | FOLDERS (CLUSTERS)
    |--------------------------------------------------------------------------
    */

    $folders = [];
    $stmt = $pdo->query("SELECT id, name FROM folders");

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $f) {
        $folders[$f['id']] = $f['name'];
    }

    /*
    |--------------------------------------------------------------------------
    | FILES = NODES
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("SELECT id, title, folder_id FROM files");
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $nodes = [];

    foreach ($files as $f) {
        $nodes[$f['id']] = [
            "id" => (int)$f['id'],
            "title" => $f['title'],
            "folder_id" => (int)$f['folder_id'],
            "folder_name" => $folders[$f['folder_id']] ?? "Unassigned"
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION LINKS (REAL + INTELLIGENT)
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("
        SELECT source_id, target_id, weight
        FROM page_relations
    ");

    $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $links = [];

    foreach ($raw as $r) {

        if (!isset($nodes[$r['source_id']]) || !isset($nodes[$r['target_id']])) {
            continue;
        }

        $links[] = [
            "source" => (int)$r['source_id'],
            "target" => (int)$r['target_id'],
            "weight" => (int)$r['weight']
        ];
    }

    return [
        "nodes" => array_values($nodes),
        "links" => $links
    ];
}