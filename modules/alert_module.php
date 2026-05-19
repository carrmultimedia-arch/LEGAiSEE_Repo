<?php

require_once __DIR__ . '/utils/json_helpers.php';

$cases = load_json_dir(__DIR__ . '/../data/cases');

$alerts = [];

foreach ($cases as $c) {

    $patterns = $c['analysis']['patterns'] ?? [];

    foreach ($patterns as $p) {

        // SIMPLE RULES (expand later)
        if (strpos($p, 'delay') !== false) {
            $alerts[] = [
                'level' => 'HIGH',
                'message' => "Operational delay detected",
                'case' => $c['id']
            ];
        }

        if (strpos($p, 'staff') !== false) {
            $alerts[] = [
                'level' => 'MEDIUM',
                'message' => "Staffing pressure",
                'case' => $c['id']
            ];
        }

        if (strpos($p, 'lead_drop') !== false) {
            $alerts[] = [
                'level' => 'HIGH',
                'message' => "Lead decline detected",
                'case' => $c['id']
            ];
        }
    }
}

return [
    'title' => 'System Alerts',
    'type' => 'alert',
    'items' => [
        [
            'title' => 'Active Alerts',
            'meta' => count($alerts) . ' alerts',
            'content' => json_encode($alerts, JSON_PRETTY_PRINT)
        ]
    ]
];