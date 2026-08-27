<?php

declare(strict_types=1);

use App\Core\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testRequestCapturesMethod(): void
    {
        $request = new Request(
            [],
            [],
            [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/projects',
            ]
        );


        $this->assertEquals(
            'POST',
            $request->method()
        );
    }


    public function testRequestCapturesUri(): void
    {
        $request = new Request(
            [],
            [],
            [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/projects?id=10',
            ]
        );


        $this->assertEquals(
            '/projects',
            $request->uri()
        );
    }


    public function testInputReadsBodyAndQueryValues(): void
    {
        $request = new Request(
            [
                'page' => 2,
            ],
            [
                'name' => 'Project Alpha',
            ]
        );


        $this->assertEquals(
            'Project Alpha',
            $request->input('name')
        );


        $this->assertEquals(
            2,
            $request->input('page')
        );


        $this->assertNull(
            $request->input('missing')
        );
    }
}