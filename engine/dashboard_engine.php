<?php

function renderDashboardPath($path){

    $recommendFile = $path . "recommendations.json";

    if(!file_exists($recommendFile)){
        return "<div>No recommendations available</div>";
    }

    $recommendations = json_decode(file_get_contents($recommendFile), true);

    $html = "";

    foreach($recommendations as $rec){

        $color = "#888";
        if($rec['priority'] === 'high') $color = "#ff4d4d";
        if($rec['priority'] === 'medium') $color = "#ffaa00";

        $html .= "
        <div style='border:1px solid #333; padding:15px; margin:10px 0; background:#111;'>
            <div style='font-size:18px; font-weight:bold;'>{$rec['title']}</div>
            <div>{$rec['action']}</div>
            <div style='color:$color;'>Priority: {$rec['priority']}</div>
        </div>";
    }

    return $html;
}