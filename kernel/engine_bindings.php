<?php

return [

    'brain' => [
        'engines' => [
            'cross_case_engine.php',
            'system_insight_engine.php',
            'system_recommendation_engine.php'
        ]
    ],

    'cases' => [
        'engines' => [
            'cross_case_engine.php'
        ]
    ],

    'clients' => [
        'engines' => [
            'cross_case_engine.php'
        ]
    ],

    'insight' => [
        'engines' => [
            'system_insight_engine.php'
        ]
    ],

    'predictive' => [
        'engines' => [
            'decision_engine_v2.php'
        ]
    ],

    'decision' => [
        'engines' => [
            'policy_enforcement_engine.php',
            'execution_router.php'
        ]
    ]
];