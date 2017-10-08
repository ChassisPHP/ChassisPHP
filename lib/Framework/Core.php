<?php

namespace Lib\Framework;

use Lib\Framework\Container;
use FastRoute\RouteCollector;

class Core
{

    protected $container;
    protected $router;
    protected $request;
    protected $response;
    protected $baseDir;
    protected $dotenv;
    protected $routeDefinitionCallback;
    protected $logger;

    public function __construct()
    {
        $this->container = new Container;
        $this->request = $this->container->get('PsrRequestInterface');
        $this->baseDir = $this->container->get('BaseDir');
        $this->dotenv = $this->container->get('Dotenv');
        $this->router = $this->container->get('Router');
        $this->logger = $this->container->get('Logger');
        $this->template = $this->container->get('Twig');
    }

    public function getContainer()
    {
        return $this->container;
    }

    // if a non-existent core method is called
    // check for it on the container
    // call it if it exists
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $containerMethod = $this->container->get($method);
            if (is_callable($containerMethod)) {
                return call_user_func_array($containerMethod, $args);
            }
        }
        throw new \BadMethodCallException("Method $method is not valid");
    }

    // Associates an URL with a callback function
    public function map($path, $controller)
    {
           $this->routes[$path] = $controller;
    }

    // read in all routes defined in files im the routes directory
    public function readRoutes($r)
    {
        $routesDir = $this->baseDir . '/routes/*.php';
        foreach (glob($routesDir) as $routeFile) {
            $routes = include($routeFile);
            $routeGroup = "/" . basename($routeFile, ".php");
        
            foreach ($routes as $route) {
                if ($routeGroup != "/frontend") {
                    $route[1] = $routeGroup . $route[1];
                }
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        }
    }

    // Generate the response
    public function run()
    {
        // create the collection of routes
        $this->routeDefinitionCallback = function (RouteCollector $r) {
            $this->readRoutes($r);
        };
        
        $this->router->dispatch($this->request, $this->routeDefinitionCallback);
    }

    // Clean up
    public function destroy()
    {
        // Clean up the session variable
        Session::destroy();

        // other cleanup??
    }
}
