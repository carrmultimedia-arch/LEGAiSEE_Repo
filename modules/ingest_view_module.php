<?php

global $db;

if (!$db) {
    return [
        'type' => 'system',
        'message' => 'DB not available for view module'
    ];
}

$rows = $db->query("
    SELECT id, session_title, source_ai, created_at
    FROM memory_ingests
    ORDER BY id DESC
    LIMIT 20
")->fetchAll();

$items = [];

foreach ($rows as $r) {
    $items[] = [
        'title' => $r['session_title'] ?: 'Untitled',
        'meta' => $r['source_ai'] . ' • ' . $r['created_at']
    ];
}

return [
    'type' => 'list',
    'title' => 'Ingested Memory',
    'items' => $items
];