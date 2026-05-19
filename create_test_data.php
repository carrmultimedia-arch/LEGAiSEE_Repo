<?php

require_once __DIR__ . '/engine/client_manager.php';
require_once __DIR__ . '/engine/case_manager.php';

/*
CREATE CLIENT
*/
$client = createClient("Test Client");

/*
CREATE CASE
*/
$case = createCase($client['id'], "Test Case");

/*
CONFIRM PATHS
*/
echo json_encode([
    "client" => $client,
    "case" => $case,
    "path" => "/data/clients/".$client['id']."/cases/".$case['id']."/"
], JSON_PRETTY_PRINT);