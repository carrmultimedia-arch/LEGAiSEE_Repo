<?php

function loadSystemBehaviorSpec(){

    return [

        "primary_domain" => "client_business_intelligence",

        "secondary_domain" => "personal_intelligence_archive",

        "optimization_priority" => [
            "revenue_relevance" => 1.5,
            "data_completeness" => 1.3,
            "speed_of_execution" => 1.2,
            "historical_accuracy" => 1.4,
            "system_stability" => 2.0
        ],

        "allowed_expansion_domains" => [
            "crm_system",
            "archaeology_ai",
            "document_intelligence",
            "media_analysis",
            "field_data_processing"
        ],

        "prohibited_behaviors" => [
            "unbounded_goal_generation",
            "cross_domain_data_corruption",
            "direct_execution_bypass",
            "memory_without_graph_record"
        ],

        "portability_mode" => true,

        "storage_model" => "graph_first",
    ];
}