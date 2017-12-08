<?php

namespace Tests;

use Tests\TestCase;
use Lib\Framework\Hash;

class HashTest extends TestCase
{
    private $hashedPW;
    private $clearTxtPW;
    private $PWcheck;
    private $hash;

    public function setup()
    {
        $this->hash = new Hash;
    }

    public function testMake()
    {
        $this->hashedPW = $this->hash->make('password');
        $this->assertNotNull($this->hashedPW);
    }

    public function testCheck()
    {
        $this->hashedPW = $this->hash->make('password');
        $this->PWcheck = $this->hash->check('password', $this->hashedPW);
        $this->assertTrue($this->PWcheck);
        $this->PWcheck = $this->hash->check('notPassword', $this->hashedPW);
        $this->assertFalse($this->PWcheck);
    }
}
