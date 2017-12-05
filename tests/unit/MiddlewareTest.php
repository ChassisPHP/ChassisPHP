<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJarInterface;

class MiddlewareTest extends TestCase
{
    private $http;
    private $app;

    public function setUp()
    {
        $this->http = new Client(
            [
                'base_uri' => 'https://chassis.local/',                 'verify' => false,
                'cookies' => true,
            ]
        );
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testAuth()
    {
        $response = $this->http->request('GET', '/backend/users');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("text/html; charset=UTF-8", $contentType);
        $body = $response->getBody();
        $body = $body->getContents();
        $this->assertContains(
            'The page you attempted to access requires that you log in ',
            $body
        );
    }
}
