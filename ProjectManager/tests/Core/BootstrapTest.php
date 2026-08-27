<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class BootstrapTest extends TestCase
{
    public function testBootstrapLoadsConfiguration(): void
    {
        $config = require __DIR__ . '/../../bootstrap.php';

        $this->assertIsArray($config);

        $this->assertArrayHasKey(
            'app',
            $config
        );

        $this->assertArrayHasKey(
            'database',
            $config
        );
    }


    public function testBasePathIsDefined(): void
    {
        require_once __DIR__ . '/../../bootstrap.php';

        $this->assertTrue(
            defined('BASE_PATH')
        );
    }
}