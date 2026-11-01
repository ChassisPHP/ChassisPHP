<?php

namespace Tests\Unit;

use Tests\TestCase;
use FastRoute\RouteCollector;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use ChassisPHP\Framework\Router;
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
