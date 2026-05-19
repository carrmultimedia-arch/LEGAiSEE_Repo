<?php

/*
================================================
LEGAISEE RUN WORKER API (CLEAN + VALID JSON)
================================================
*/

error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

/*
================================================
RUN WORKER
================================================
*/

$output = shell_exec("php /home/carrmulti/www/www/commandcenter/cli/worker.php");

/*
================================================
TRY TO PASS THROUGH JSON CLEANLY
================================================
*/

// Attempt to decode worker output
$decoded = json_decode($output, true);

if ($decoded !== null) {
    // Worker already returned valid JSON → pass it through
    echo json_encode($decoded);
} else {
    // Worker returned raw text → wrap safely
    echo json_encode([
        "status" => "ok",
        "worker_raw" => $output
    ]);
}

exit;