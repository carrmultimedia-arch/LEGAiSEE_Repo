<?php
declare(strict_types=1);

require_once __DIR__ . '/utils/bootstrap.php';

$cases = load_json_dir(__DIR__ . '/../data/cases');

$recommendations = [];

foreach ($cases as $case) {
    $caseId  = $case['id'] ?? 'unknown';
    $status  = $case['status'] ?? 'unknown';
    $patterns = $case['analysis']['patterns'] ?? $case['patterns'] ?? [];

    foreach ($patterns as $pattern) {
        $actionMap = [
            'ops_delay'        => ['title' => 'Resolve Operational Delays',    'action' => 'Audit service delivery workflow and identify bottlenecks.', 'priority' => 'high'],
            'pricing_pressure' => ['title' => 'Address Pricing Friction',      'action' => 'Review pricing structure vs perceived value signals.',       'priority' => 'high'],
            'lead_friction'    => ['title' => 'Fix Lead Conversion Breakdown', 'action' => 'Audit funnel messaging and conversion touchpoints.',          'priority' => 'high'],
            'labor_issue'      => ['title' => 'Stabilize Workforce Signals',   'action' => 'Investigate staffing consistency and delivery quality.',      'priority' => 'medium'],
        ];

        $rec = $actionMap[$pattern] ?? [
            'title'    => 'Investigate Pattern: ' . $pattern,
            'action'   => 'Review contributing artifacts and validate business impact.',
            'priority' => 'medium'
        ];

        $recommendations[] = [
            'title'    => $rec['title'],
            'meta'     => 'Priority: ' . $rec['priority'] . ' — Case: ' . $caseId,
            'content'  => $rec['action']
        ];
    }
}

if (empty($recommendations)) {
    $recommendations[] = [
        'title'   => 'No Patterns Detected',
        'meta'    => 'Run excavation pipeline to generate signals',
        'content' => 'Ingest client artifacts to begin generating recommendations.'
    ];
}

return [
    'type'  => 'list',
    'title' => 'Recommendations',
    'items' => $recommendations
];