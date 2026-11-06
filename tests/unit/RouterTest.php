<?php

namespace Tests\Unit;

use Tests\TestCase;
use FastRoute\RouteCollector;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use ChassisPHP\Framework\Router;
use ChassisPHP\Framework\Session;
use ChassisPHP\Framework\Container;
use ChassisPHP\Framework\Http\MiddlewareQueue;

class RouterTest extends TestCase
{
    private function request($method, $uri)
    {
        return new ServerRequest(['REQUEST_URI' => $uri], [], $uri, $method);
    }

    private function router($request)
    {
        $response = new Response();
        return new Router($request, $response, new MiddlewareQueue($request, $response));
    }

    private function routes()
    {
        return function (RouteCollector $r) {
            $r->addRoute('GET', '/hello/{name}', function ($vars) {
                return 'Hello ' . $vars['name'];
            });
            $r->addRoute('POST', '/form', function ($vars) {
                return 'posted';
            });
        };
    }

    public function testGetRouteInfoStripsTrailingSlash()
    {
        $request = $this->request('GET', '/hello/World/');

        $routeInfo = $this->router($request)->getRouteInfo($request, $this->routes());

        $this->assertSame(\FastRoute\Dispatcher::FOUND, $routeInfo[0]);
        $this->assertSame(['name' => 'World'], $routeInfo[2]);
    }

    public function testGetRouteInfoIgnoresQueryString()
    {
        $request = $this->request('GET', '/hello/World?greeting=hi&x=1');

        $routeInfo = $this->router($request)->getRouteInfo($request, $this->routes());

        $this->assertSame(\FastRoute\Dispatcher::FOUND, $routeInfo[0]);
        $this->assertSame(['name' => 'World'], $routeInfo[2]);
    }

    public function testGetRouteInfoStripsTrailingSlashBeforeQueryString()
    {
        $request = $this->request('GET', '/hello/World/?x=1');

        $routeInfo = $this->router($request)->getRouteInfo($request, $this->routes());

        $this->assertSame(\FastRoute\Dispatcher::FOUND, $routeInfo[0]);
        $this->assertSame(['name' => 'World'], $routeInfo[2]);
    }

    public function testDispatchClosureRoute()
    {
        $request = $this->request('GET', '/hello/World');

        $response = $this->router($request)->dispatch($request, $this->routes(), null);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('Hello World', (string) $response->getBody());
    }

    public function testDispatchNotFound()
    {
        $request = $this->request('GET', '/nowhere');

        $response = $this->router($request)->dispatch($request, $this->routes(), null);

        $this->assertSame(404, $response->getStatusCode());
    }

    public function testDispatchMethodNotAllowed()
    {
        $request = $this->request('GET', '/form');

        $response = $this->router($request)->dispatch($request, $this->routes(), null);

        $this->assertSame(405, $response->getStatusCode());
        $this->assertSame('POST', $response->getHeaderLine('Allow'));
    }

    private function protectedRoute(&$controllerRan)
    {
        return function (RouteCollector $r) use (&$controllerRan) {
            $r->addRoute('POST', '/protected', function ($vars) use (&$controllerRan) {
                $controllerRan = true;
                return 'protected content';
            });
        };
    }

    private function protectedRouter($request)
    {
        $response = new Response();
        $queue = new MiddlewareQueue($request, $response);
        $queue->addMiddleware('AuthMiddleware', '\ChassisPHP\Framework\Http\Middleware\\');

        return new Router($request, $response, $queue);
    }

    public function testProtectedRouteDoesNotRunForAnonymousVisitor()
    {
        unset($_SESSION['authenticated']);
        $controllerRan = false;
        $request = $this->request('POST', '/protected');

        $response = $this->protectedRouter($request)
            ->dispatch($request, $this->protectedRoute($controllerRan), null);

        $this->assertFalse($controllerRan);
        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/backend/login', $response->getHeaderLine('Location'));
        $this->assertSame('', (string) $response->getBody());
    }

    public function testProtectedRouteRunsForLoggedInUser()
    {
        Session::start();
        $_SESSION['authenticated'] = true;
        $controllerRan = false;
        $request = $this->request('POST', '/protected');

        $response = $this->protectedRouter($request)
            ->dispatch($request, $this->protectedRoute($controllerRan), null);

        unset($_SESSION['authenticated']);
        $this->assertTrue($controllerRan);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('protected content', (string) $response->getBody());
    }

    public function testDispatchControllerRouteThroughContainer()
    {
        $container = new Container();
        $request = $this->request('GET', '/');
        $routes = function (RouteCollector $r) {
            $r->addRoute('GET', '/', ['HomeController', 'index']);
        };

        $response = $container->get('Router')->dispatch($request, $routes, $container);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("Home of Chassis\n", (string) $response->getBody());
    }
}
