<?php

require_once __DIR__ . '/utils/json_helpers.php';

$clients = load_json_dir(__DIR__ . '/../data/clients');

$output = [];

foreach ($clients as $c) {

    $cid = $c['id'] ?? null;
    if (!$cid) continue;

    $metaDir = __DIR__ . '/../data/clients/' . $cid . '/artifacts/metadata';

    if (!is_dir($metaDir)) continue;

    $files = array_filter(scandir($metaDir), fn($f)=>strpos($f,'.json'));

    $artifacts = [];

    foreach ($files as $f) {

        $data = json_decode(file_get_contents($metaDir.'/'.$f), true);
        if (!$data) continue;

        $artifacts[] = $data;
    }

    $output[] = [
        'client_id' => $cid,
        'artifacts' => $artifacts
    ];
}

return [
    'title' => 'Archeology Vault',
    'type' => 'vault',
    'items' => [
        [
            'title' => 'Artifacts',
            'meta' => count($output) . ' clients',
            'content' => json_encode($output, JSON_PRETTY_PRINT)
        ]
    ]
];