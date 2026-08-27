<?php

global $db;

if (!$db) {
    return [
        'type' => 'system',
        'message' => 'DB not available for view module'
    ];
}

$rows = $db->query("
    SELECT id, session_label, platform, created_at
    FROM memory_ingest
    ORDER BY id DESC
    LIMIT 20
")->fetchAll();

$items = [];

foreach ($rows as $r) {
    $items[] = [
        'title' => $r['session_label'] ?: 'Untitled',
        'meta' => $r['platform'] . ' • ' . $r['created_at']
    ];
}

return [
    'type' => 'list',
    'title' => 'Ingested Memory',
    'items' => $items
];