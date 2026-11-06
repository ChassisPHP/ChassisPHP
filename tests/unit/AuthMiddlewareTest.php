<?php

namespace Tests\Unit;

use Tests\TestCase;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use ChassisPHP\Framework\Http\Middleware\AuthMiddleware;

class AuthMiddlewareTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        $_SESSION = [];
        $this->request = new ServerRequest(['REQUEST_URI' => '/backend/users']);
    }

    public function tearDown(): void
    {
        $_SESSION = [];
    }

    public function testAnonymousVisitorIsRedirectedToLogin()
    {
        $next = function () {
            $this->fail('The next middleware must not run');
        };

        $response = (new AuthMiddleware())($this->request, new Response(), $next);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/backend/login', $response->getHeaderLine('Location'));
    }

    public function testAnonymousVisitorIsSentBackAfterLogin()
    {
        (new AuthMiddleware())($this->request, new Response());

        $this->assertSame('/backend/users', $_SESSION['history']);
        $this->assertSame('warning', $_SESSION['message']['type']);
    }

    public function testLoggedInUserContinues()
    {
        $_SESSION['authenticated'] = true;
        $next = function ($request, $response) {
            return $response->withStatus(204);
        };

        $response = (new AuthMiddleware())($this->request, new Response(), $next);

        $this->assertSame(204, $response->getStatusCode());
    }
}
