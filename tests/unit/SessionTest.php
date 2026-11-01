<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\Session;

class SessionTest extends TestCase
{
    public function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
        Session::$sessionStarted = false;
    }

    public function testSetGet()
    {
        Session::set('testKey', 'Value Test');

        $this->assertSame('Value Test', Session::get('testKey'));
    }

    public function testGetMissingKeyReturnsFalse()
    {
        $this->assertFalse(Session::get('missing'));
        $this->assertFalse(Session::get('missing', 'child'));
    }

    public function testGetChildKey()
    {
        Session::set('user', ['name' => 'Roger']);

        $this->assertSame('Roger', Session::get('user', 'name'));
        $this->assertFalse(Session::get('user', 'email'));
    }

    public function testClear()
    {
        Session::set('testKey', 'value');
        Session::clear('testKey');

        $this->assertFalse(Session::get('testKey'));
    }

    public function testGetMessageUnsetsByDefault()
    {
        Session::setMessage('warning', 'Careful');

        $this->assertSame(['type' => 'warning', 'content' => 'Careful'], Session::getMessage());
        $this->assertFalse(Session::getMessage());
    }

    public function testGetMessageCanKeepMessage()
    {
        Session::setMessage('info', 'Kept');

        Session::getMessage(false);
        $this->assertSame(['type' => 'info', 'content' => 'Kept'], Session::getMessage());
    }

    public function testStartAndDestroy()
    {
        Session::start();
        $this->assertSame(PHP_SESSION_ACTIVE, session_status());
        $this->assertTrue(Session::$sessionStarted);

        Session::destroy();
        $this->assertSame(PHP_SESSION_NONE, session_status());
        $this->assertFalse(Session::$sessionStarted);
    }

    public function testStartMarksAlreadyActiveSessionAsStarted()
    {
        // the skeleton's index.php calls session_start() itself
        session_start();

        Session::start();

        $this->assertTrue(Session::$sessionStarted);
    }
}
