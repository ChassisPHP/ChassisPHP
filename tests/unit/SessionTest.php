<?php

namespace Tests;

use Tests\TestCase;
use Lib\Framework\Session;

class SessionTest extends TestCase
{
    private $testValue;
    private $session;

    public function setup()
    {
        $this->session = new Session;
        $this->testValue = 'Value Test';
    }

    /*
     * phpunit sends headers..so, this test errors
     * "headers already sent"
     * TODO workaround?
    public function testStartSession()
    {
        $this->session->start();
        $this->assertSame(session_status(), PHP_SESSION_NONE);
    }
     */

    public function testSetGet()
    {
        $this->session->set('testKey', $this->testValue);
        $test = $this->session->get('testKey');
        $this->assertSame($test, $this->testValue);
    }

    /*
     * same problem as testStartSession above
     *
    public function testDestroy()
    {
        $this->session->start();
        $this->session->destroy();
        $this->assertNull(session_status());
    }
     */
}
