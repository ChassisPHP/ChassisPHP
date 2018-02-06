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

    // confirm that user list page requires log in
    public function testUsersAuth()
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

    // confirm that user register page requires log in
    public function testRegistrationAuth()
    {
        $response = $this->http->request('GET', '/backend/users/register');

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
    
    // confirm that content list page requires log in
    public function testContentAuth()
    {
        $response = $this->http->request('GET', '/backend/content');

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
    
    // confirm that content detail page requires log in
    public function testContentDetailAuth()
    {
        $response = $this->http->request('GET', '/backend/content/1');

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
    
    // confirm that content update page requires log in
    public function testContentUpdateDetailAuth()
    {
        $response = $this->http->request('GET', '/backend/content/update/1');

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
