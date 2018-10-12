<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJarInterface;
use Symfony\Component\Process\Process;

class MiddlewareTest extends TestCase
{
    private $http;
    private $app;
    private $process;

    public function setUp()
    {
        $public_path = realpath(__DIR__.'/../../public');
        $this->process = new Process("php -S localhost:8890 -t $public_path");
        $this->process->start();
        $this->http = new Client(
            [
                'base_uri' => 'http://localhost:8890',
                'verify' => false,
                'cookies' => true,
            ]
        );
    }

    public function tearDown()
    {
        $this->http = null;
        $this->process->stop();
    }

    // confirm that user list page requires log in
    public function testUsersAuth()
    {
        $response = $this->http->request('GET', '/backend/users');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeader('Content-Type')[0];
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

        $contentType = $response->getHeader('Content-Type')[0];
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

        $contentType = $response->getHeader('Content-Type')[0];
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

        $contentType = $response->getHeader('Content-Type')[0];
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

        $contentType = $response->getHeader('Content-Type')[0];
        $this->assertEquals("text/html; charset=UTF-8", $contentType);
        $body = $response->getBody();
        $body = $body->getContents();
        $this->assertContains(
            'The page you attempted to access requires that you log in ',
            $body
        );
    }
}
