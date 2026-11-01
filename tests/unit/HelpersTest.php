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

    public function testStoragePathIsInsideAppRoot()
    {
        $storage = APP_ROOT . DIRECTORY_SEPARATOR . 'storage';

        $this->assertSame($storage, storagePath());
        $this->assertSame($storage . DIRECTORY_SEPARATOR . 'logs', storagePath('logs'));
    }

    public function testLogToWritesToAppStorage()
    {
        $logFile = storagePath('logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_error.log');
        @unlink($logFile);

        logTo('error', 'logTo test entry');
        logTo('error', 'second entry');

        $this->assertFileExists($logFile);
        $contents = file_get_contents($logFile);
        $this->assertStringContainsString('logTo test entry', $contents);
        $this->assertStringContainsString('second entry', $contents);

        unlink($logFile);
    }

    public function testCheckAuth()
    {
        $_SESSION = [];
        $this->assertFalse(checkAuth());

        Session::set('authenticated', true);
        $this->assertTrue(checkAuth());
    }
}
