<?php

require_once __DIR__ . '/../../engine/client_manager.php';

header('Content-Type: application/json');

echo json_encode(getClients());