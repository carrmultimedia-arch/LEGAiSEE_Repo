<?php

/*
================================================
GOVERNANCE POLICY ENGINE v1.0
Defines what system is allowed to optimize for
================================================
*/

function loadGovernancePolicy(){

    return [
        /*
        ============================================
        CORE SYSTEM CONSTRAINTS
        ============================================
        */

        "max_active_goals" => 10,
        "max_task_queue_size" => 200,
        "max_mutations_per_cycle" => 15,

        /*
        ============================================
        PROHIBITED BEHAVIORS
        ============================================
        */

        "blocked_task_types" => [
            "self_rewrite_core",
            "unbounded_spawn",
            "goal_override_loop"
        ],

        /*
        ============================================
        STABILITY CONSTRAINTS
        ============================================
        */

        "min_goal_confidence" => 60,
        "min_plan_horizon" => "short",

        /*
        ============================================
        PRIORITY BIAS
        ============================================
        */

        "bias_weights" => [
            "stability" => 1.5,
            "growth" => 1.2,
            "exploration" => 0.8
        ]
    ];
}