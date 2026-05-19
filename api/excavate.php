<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$file = $input['file'] ?? '';

$path = __DIR__ . "/../normalized/" . $file;

if(!file_exists($path)){
    echo json_encode(["error"=>"file not found"]);
    exit;
}

$content = file_get_contents($path);

/* SIMULATED MULTI-MODEL OUTPUT */
$models = [
    "chatgpt",
    "claude",
    "gemini",
    "perplexity"
];

$analysis = [];

foreach($models as $m){
    $analysis[$m] = [
        "model"=>$m,
        "summary"=>"[$m] extracted key patterns from document",
        "signals"=>[
            "entities"=>["pattern recognition", "timeline markers"],
            "intent"=>"structural analysis",
            "risk"=>rand(1,10),
            "value_score"=>rand(60,100)
        ]
    ];
}

/* SYNTHESIS LAYER */
$synthesis = [
    "file"=>$file,
    "core_insight"=>"Composite intelligence extracted across 4 models",
    "themes"=>["structure","intent","pattern density"],
    "confidence"=>rand(70,98),
    "models"=>$analysis
];

/* WRITE CACHE */
file_put_contents(__DIR__."/intel_cache.json", json_encode($synthesis, JSON_PRETTY_PRINT));

echo json_encode($synthesis);