<?php
header('Content-Type: application/json');

$file = __DIR__ . "/../../data/learning.json";
require_once __DIR__ . '/../../lib/semantic_diff_engine.php';

$input = json_decode(file_get_contents("php://input"), true);

$pattern = $input['pattern'] ?? '';
$outcome = $input['outcome'] ?? ''; // "useful" | "useless"

if (!$pattern || !$outcome) {
    echo json_encode(["error"=>"missing data"]);
    exit;
}

$memory = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$found = false;

/* UPDATE EXISTING PATTERN */
foreach ($memory as &$m) {
    if ($m['pattern'] === $pattern) {

        if ($outcome === "useful") {
            $m['weight'] += 1;
        } else {
            $m['weight'] -= 1;
        }

        $m['count'] += 1;
        $found = true;
        break;
    }
}

/* NEW PATTERN */
if (!$found) {
    $memory[] = [
        "pattern"=>$pattern,
        "weight"=>1,
        "count"=>1
    ];
}

file_put_contents($file, json_encode($memory, JSON_PRETTY_PRINT));

echo json_encode([
    "success"=>true,
    "patterns_updated"=>$memory
]);
echo json_encode($response);
exit;
