<?php

function generateRecommendationsFromPath($path){

    $file = $path . "insights.json";
    $outputFile = $path . "recommendations.json";

    $recommendations = [];

    if(file_exists($file)){

        $insights = json_decode(file_get_contents($file), true);

        foreach($insights as $insight){

            $type = $insight['type'] ?? '';

            // GENERIC MAPPINGS (NOT STRICT)

            if(strpos($type, 'risk') !== false){

                $recommendations[] = [
                    "type" => "action",
                    "title" => "Risk Exposure Detected",
                    "action" => "Review risk signals and reduce exposure",
                    "priority" => "high"
                ];
            }

            elseif(strpos($type, 'growth') !== false){

                $recommendations[] = [
                    "type" => "action",
                    "title" => "Growth Opportunity Detected",
                    "action" => "Increase allocation to performing channels",
                    "priority" => "medium"
                ];
            }

            elseif(strpos($type, 'engagement') !== false){

                $recommendations[] = [
                    "type" => "action",
                    "title" => "Engagement Shift Detected",
                    "action" => "Audit content performance trends",
                    "priority" => "high"
                ];
            }

            else {
                // SAFE DEFAULT
                $recommendations[] = [
                    "type" => "action",
                    "title" => "General System Signal",
                    "action" => "Review data for emerging patterns",
                    "priority" => "low"
                ];
            }
        }
    }

    // FINAL GUARANTEE FALLBACK (NEVER EMPTY)
    if(empty($recommendations)){

        $recommendations[] = [
            "type" => "fallback",
            "title" => "System Active - No Strong Patterns",
            "action" => "Continue monitoring incoming signals",
            "priority" => "low"
        ];
    }

    file_put_contents($outputFile, json_encode($recommendations, JSON_PRETTY_PRINT));

    return $recommendations;
}