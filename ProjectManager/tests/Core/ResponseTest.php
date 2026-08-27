<?php

declare(strict_types=1);

use App\Core\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testResponseStoresContent(): void
    {
        $response = new Response(
            'success'
        );


        $this->assertEquals(
            'success',
            $response->getContent()
        );


        $this->assertEquals(
            200,
            $response->status()
        );
    }


    public function testJsonResponseSetsContentType(): void
    {
        $response = new Response();


        $response->json(
            [
                'status' => 'ok',
            ]
        );


        $this->assertStringContainsString(
            'status',
            $response->getContent()
        );


        $this->assertEquals(
            200,
            $response->status()
        );
    }


    public function testCustomStatusCode(): void
    {
        $response = new Response(
            'created',
            201
        );


        $this->assertEquals(
            201,
            $response->status()
        );
    }
}