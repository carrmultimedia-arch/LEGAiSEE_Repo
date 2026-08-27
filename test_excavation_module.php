<?php
// Test excavation_module.php against WO-C test case
require_once __DIR__ . '/kernel/kernel_boot.php';
require_once __DIR__ . '/modules/utils/bootstrap.php';

echo "Testing excavation_module.php\n";
echo "=============================\n\n";

$result = require __DIR__ . '/modules/excavation_module.php';

echo "Excavation Module Output:\n";
echo json_encode($result, JSON_PRETTY_PRINT) . "\n\n";

echo "✓ excavation_module.php executed successfully\n";
