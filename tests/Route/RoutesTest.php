<?php

namespace Tests\RoutesTest;

use Tests\TestCase;
use Zend\Diactoros\ServerRequestFactory;
use GuzzleHttp\Client;

class RoutesTest extends TestCase
{
    private $http;
    private $app;

    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'https://chassis.local/', 'verify' => false]);
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testGet()
    {
        $response = $this->http->request('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("text/html; charset=UTF-8", $contentType);
    }
}
