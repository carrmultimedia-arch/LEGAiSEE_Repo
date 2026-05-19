<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| BRAIN MODULE
|--------------------------------------------------------------------------
| SYSTEM INTELLIGENCE INSPECTION LAYER
|--------------------------------------------------------------------------
| - NO UI LOGIC
| - NO FILE WRITING
| - READ-ONLY SYSTEM AWARENESS
|--------------------------------------------------------------------------
*/

$modules = require __DIR__ . '/../kernel/module_registry.php';

$dataRoot = __DIR__ . '/../data';

function dir_summary(string $path): array
{
    if (!is_dir($path)) {
        return [
            'exists' => false,
            'path' => $path,
            'count' => 0
        ];
    }

    $items = array_values(array_filter(scandir($path), function ($f) {
        return $f !== '.' && $f !== '..';
    }));

    return [
        'exists' => true,
        'path' => $path,
        'count' => count($items)
    ];
}

$brain = [

    'system' => [
        'status' => 'ACTIVE',
        'mode' => 'INSPECTION_ONLY',
        'shell' => 'CONNECTED'
    ],

    'modules' => [
        'registered_count' => count($modules),
        'active_modules' => array_keys($modules)
    ],

    'data_layer' => [
        'files' => dir_summary($dataRoot . '/files'),
        'clients' => dir_summary($dataRoot . '/clients'),
        'cases' => dir_summary($dataRoot . '/cases'),
        'memory' => dir_summary($dataRoot . '/memory'),
    ],

    'engines' => [
        'cross_case_engine' => file_exists(__DIR__ . '/../system/cross_case_engine.php'),
        'insight_engine' => file_exists(__DIR__ . '/../system/system_insight_engine.php'),
        'decision_engine' => file_exists(__DIR__ . '/../system/decision_engine_v2.php'),
        'recommendation_engine' => file_exists(__DIR__ . '/../system/system_recommendation_engine.php'),
        'policy_engine' => file_exists(__DIR__ . '/../system/policy_enforcement_engine.php'),
    ],

    'health' => [
        'data_layer_ready' =>
            is_dir($dataRoot . '/files') &&
            is_dir($dataRoot . '/clients') &&
            is_dir($dataRoot . '/cases') &&
            is_dir($dataRoot . '/memory')
    ]
];

return [
    'title' => 'Brain',
    'type' => 'inspector',
    'items' => [
        [
            'title' => 'System Status',
            'meta' => $brain['system']['status'],
            'content' => json_encode($brain['system'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Module Registry',
            'meta' => count($modules) . ' modules',
            'content' => json_encode($brain['modules'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Data Layer',
            'meta' => $brain['health']['data_layer_ready'] ? 'READY' : 'INCOMPLETE',
            'content' => json_encode($brain['data_layer'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Engines',
            'meta' => 'system scan',
            'content' => json_encode($brain['engines'], JSON_PRETTY_PRINT)
        ]
    ]
];