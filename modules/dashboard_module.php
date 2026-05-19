<?php

require_once __DIR__ . '/utils/bootstrap.php';

$cases   = load_json_dir(__DIR__ . '/../data/cases');
$clients = load_json_dir(__DIR__ . '/../data/clients');

return [
    'type'  => 'list',
    'title' => 'System Dashboard',
    'items' => [
        [
            'title'   => 'Totals',
            'meta'    => 'Overview',
            'content' => json_encode([
                'cases'   => count($cases),
                'clients' => count($clients)
            ], JSON_PRETTY_PRINT)
        ]
    ]
];