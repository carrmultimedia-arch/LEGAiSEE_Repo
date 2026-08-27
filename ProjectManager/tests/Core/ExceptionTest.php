<?php

declare(strict_types=1);

use App\Core\ExceptionHandler;
use PHPUnit\Framework\TestCase;

final class ExceptionTest extends TestCase
{
    public function testExceptionHandlerClassExists(): void
    {
        $this->assertTrue(
            class_exists(
                ExceptionHandler::class
            )
        );
    }


    public function testExceptionCanBeHandled(): void
    {
        $exception = new RuntimeException(
            'Test exception'
        );


        ob_start();


        ExceptionHandler::handle(
            $exception
        );


        $output = ob_get_clean();


        $this->assertIsString(
            $output
        );
    }
}