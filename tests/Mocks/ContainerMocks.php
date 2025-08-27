<?php
// tests/Mocks/ContainerMocks.php
// League Container and FastRoute mocks

namespace League\Container {

    use Psr\Container\ContainerInterface;

    if (!class_exists('Container')) {
        class Container implements ContainerInterface
        {
            private $services = [];

            public function get($id)
            {
                if (isset($this->services[$id])) {
                    $service = $this->services[$id];
                    return is_callable($service) ? $service() : $service;
                }
                throw new \Psr\Container\NotFoundException("Service '{$id}' not found");
            }

            public function has($id)
            {
                return isset($this->services[$id]);
            }

            public function add($id, $concrete = null)
            {
                $this->services[$id] = $concrete ?: $id;
                return new MockDefinition();
            }

            public function share($id, $concrete)
            {
                $this->services[$id] = is_callable($concrete) ? $concrete() : $concrete;
                return new MockDefinition();
            }

            public function addServiceProvider($provider)
            {
                return $this;
            }

            public function delegate(ContainerInterface $container)
            {
                return $this;
            }
        }
    }

    if (!class_exists('MockDefinition')) {
        class MockDefinition
        {
            public function addMethodCall($method, array $args = [])
            {
                return $this;
            }
        }
    }

    if (!class_exists('ReflectionContainer')) {
        class ReflectionContainer implements ContainerInterface
        {
            public function get($id)
            {
                if (class_exists($id)) {
                    return new $id();
                }
                throw new \Psr\Container\NotFoundException("Class '{$id}' not found");
            }

            public function has($id)
            {
                return class_exists($id);
            }
        }
    }
}

namespace League\Container\ServiceProvider {
    if (!class_exists('AbstractServiceProvider')) {
        abstract class AbstractServiceProvider
        {
            protected $container;
            protected $provides = [];

            public function setContainer(\Psr\Container\ContainerInterface $container)
            {
                $this->container = $container;
            }

            public function getContainer()
            {
                return $this->container;
            }

            abstract public function register();
        }
    }
}

namespace FastRoute {

    if (!class_exists('Dispatcher')) {
        class Dispatcher
        {
            const NOT_FOUND = 0;
            const METHOD_NOT_ALLOWED = 1;
            const FOUND = 2;
        }
    }

    if (!class_exists('RouteCollector')) {
        class RouteCollector
        {
            private $routes = [];

            public function addRoute($method, $route, $handler)
            {
                $this->routes[] = [
                    'method' => $method,
                    'route' => $route,
                    'handler' => $handler
                ];
            }

            public function getRoutes()
            {
                return $this->routes;
            }
        }
    }

    if (!function_exists('FastRoute\\simpleDispatcher')) {
        function simpleDispatcher(callable $routeDefinitionCallback)
        {
            return new MockDispatcher($routeDefinitionCallback);
        }
    }

    if (!class_exists('MockDispatcher')) {
        class MockDispatcher
        {
            private $routes = [];

            public function __construct(callable $routeDefinitionCallback)
            {
                $collector = new RouteCollector();
                $routeDefinitionCallback($collector);
                $this->routes = $collector->getRoutes();
            }

            public function dispatch($method, $uri)
            {
                foreach ($this->routes as $route) {
                    if ($route['method'] === $method) {
                        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['route']);
                        if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                            array_shift($matches);
                            return [Dispatcher::FOUND, $route['handler'], $matches];
                        }
                    }
                }
                return [Dispatcher::NOT_FOUND, null, null];
            }
        }
    }
}