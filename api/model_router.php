<?php

function call_openai($prompt){
    // placeholder - plug your API key here
    return "OpenAI_RESPONSE: ".$prompt;
}

function call_claude($prompt){
    return "CLAUDE_RESPONSE: ".$prompt;
}

function call_gemini($prompt){
    return "GEMINI_RESPONSE: ".$prompt;
}

function route_models($prompt){

    return [
        "openai"=>call_openai($prompt),
        "claude"=>call_claude($prompt),
        "gemini"=>call_gemini($prompt)
    ];
}