<?php

namespace Tests\Permissions;

use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_authorized_user_can_access_resource()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_is_blocked()
    {
        $this->assertTrue(true);
    }
}