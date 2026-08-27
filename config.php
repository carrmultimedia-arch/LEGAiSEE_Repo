<?php

/**
 * LEGAiSEE Configuration
 * MySQL only. Real credentials live in config.local.php (not committed/shared).
 */

// Load local overrides if they exist
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}