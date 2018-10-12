<?php

namespace Tests\RoutesTest;

use Tests\TestCase;
use Zend\Diactoros\ServerRequestFactory;
use GuzzleHttp\Client;
use Symfony\Component\Process\Process;

class RoutesTest extends TestCase
{
    private $http;
    private $app;
    private $process;

    public function setUp()
    {
        $public_path = realpath(__DIR__.'/../../public');
        $this->process = new Process("php -S localhost:8890 -t public/");
        $this->process->start();
        $this->http = new Client(['base_uri' => 'http://localhost:8890', 'verify' => false]);
    }

    public function tearDown()
    {
        $this->http = null;
        $this->process->stop();
    }

    public function testGet()
    {
        $response = $this->http->request('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeader('Content-Type')[0];
        $this->assertEquals("text/html; charset=UTF-8", $contentType);
    }
}
