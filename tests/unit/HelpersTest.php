<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\Session;

class HelpersTest extends TestCase
{
    private $server;

    public function setUp(): void
    {
        $this->server = $_SERVER;
    }

    public function tearDown(): void
    {
        $_SERVER = $this->server;
    }

    public function testEnvar()
    {
        putenv('CHASSIS_HELPER_TEST=value');

        $this->assertSame('value', envar('CHASSIS_HELPER_TEST'));
        $this->assertSame('default', envar('CHASSIS_HELPER_MISSING', 'default'));
        $this->assertNull(envar('CHASSIS_HELPER_MISSING'));

        putenv('CHASSIS_HELPER_TEST');
    }

    public function testBaseUrl()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        unset($_SERVER['HTTPS']);
        $this->assertSame('http://example.com/', baseURL());

        $_SERVER['HTTPS'] = 'on';
        $this->assertSame('https://example.com/', baseURL());
    }

    public function testStoragePath()
    {
        // Current behavior: resolves relative to the framework package, not APP_ROOT.
        // When installed under vendor/ this points inside the package.
        $root = dirname(__DIR__, 2);

        $this->assertSame($root . DIRECTORY_SEPARATOR . 'storage', storagePath());
        $this->assertSame($root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs', storagePath('logs'));
    }

    public function testCheckAuth()
    {
        $_SESSION = [];
        $this->assertFalse(checkAuth());

        Session::set('authenticated', true);
        $this->assertTrue(checkAuth());
    }
}
