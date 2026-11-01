<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\Hash;

class HashTest extends TestCase
{
    public function testMakeReturnsBcryptHash()
    {
        $hash = Hash::make('password');

        $this->assertNotSame('password', $hash);
        $this->assertStringStartsWith('$2y$', $hash);
    }

    public function testCheck()
    {
        $hash = Hash::make('password');

        $this->assertTrue(Hash::check('password', $hash));
        $this->assertFalse(Hash::check('notPassword', $hash));
    }
}
