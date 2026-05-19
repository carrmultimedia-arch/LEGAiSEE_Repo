<?php
require_once __DIR__ . '/utils/bootstrap.php';
$cases = load_json_dir(__DIR__ . '/../data/cases');

$statusMap = [];
foreach ($cases as $case) {
    $status = $case['status'] ?? 'unknown';
    $statusMap[$status] = ($statusMap[$status] ?? 0) + 1;
}

return [
    'type'  => 'list',
    'title' => 'Insight Engine',
    'items' => [
        [
            'title'   => 'Status Distribution',
            'meta'    => count($cases) . ' cases',
            'content' => json_encode($statusMap, JSON_PRETTY_PRINT)
        ]
    ]
];