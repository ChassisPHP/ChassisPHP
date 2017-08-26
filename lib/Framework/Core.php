<?PHP

namespace Lib\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Lib\Framework\Router;
use Lib\Framework\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

class Core implements HttpKernelInterface
{

    protected $container;
    protected $router;
    protected $request;
    protected $response;
    protected $baseDir;
    protected $routeDefinitionCallback;

    public function __construct()
    {
        $this->container = new Container;
        $this->request = $this->container->get('Request');
        $this->baseDir = $this->container->get('BaseDir');
        $this->response = new Response;
        
        // Crank up the Router
        $this->router = new Router();
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

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        
    
        return $response;
    }

    // Associates an URL with a callback function
    public function map($path, $controller)
    {
           $this->routes[$path] = $controller;
    }

    // read frontend routes from array
    public function readFrontendRoutes($r)
    {
        $routes = include($this->baseDir. '/routes/frontend.php');
        foreach ($routes as $route) {
            $r->addRoute($route[0], $route[1], $route[2]);
        }
    }

    //read backend routes from array
    public function readBackendRoutes($r)
    {
        $routes = include($this->baseDir. '/routes/backend.php');
        foreach ($routes as $route) {
            //$routeLocation = '/backend' . $route[1];
            $r->addRoute($route[0], $route[1], $route[2]);
        }
    }

    // Generate the response
    public function run()
    {
        // create the collection of routes
        $this->routeDefinitionCallback = function (RouteCollector $r) {
            $this->readFrontendRoutes($r);
            $this->readBackendRoutes($r);
        };
        
        $dispatcher = \FastRoute\simpleDispatcher($this->routeDefinitionCallback);
        $routeInfo = $dispatcher->dispatch($this->request->getMethod(), $this->request->getRequestUri());
        
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $this->response->setContent('404 - Page not found');
                $this->response->setStatusCode(404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $response->setContent('405 - Method not allowed');
                $response->setStatusCode(405);
                break;
            case Dispatcher::FOUND:
                $classname = $routeInfo[1][0];
                $method = $routeInfo[1][1];
                $vars = $routeInfo[2];
                $class = new $classname;
                $class->$method($vars);
                break;
        }
        
        $this->response->sendHeaders();
        $this->response->sendContent();
    }
}
