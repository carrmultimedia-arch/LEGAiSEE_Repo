<?php

require_once __DIR__ . '/../../engine/dashboard_engine.php';

$client_id = $_GET['client_id'] ?? '';
$case_id   = $_GET['case_id'] ?? '';

echo renderDashboardPath("/home/carrmulti/www/www/commandcenter/data/clients/$client_id/cases/$case_id/");