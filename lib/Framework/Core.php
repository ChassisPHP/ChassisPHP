<?PHP

namespace Lib\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Lib\Framework\Router;
use Lib\Framework\Container;
use Phroute\Phroute\Dispatcher;

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
       // $this->router = new Router();
       // $this->readFrontendRoutes();
       // $this->readBackendRoutes();
    }

    public function getContainer()
    {
        return $this->container;
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

    /* add routes to the router
    public function addRoute($method, $route, $function)
    {
        $this->router->addRoute($method, $route, $function);
    }*/

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
        $this->routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
            $this->readFrontendRoutes($r);
            $this->readBackendRoutes($r);
        };

        $dispatcher = \FastRoute\simpleDispatcher($this->routeDefinitionCallback);
        $routeInfo = $dispatcher->dispatch($this->request->getMethod(), $this->request->getRequestUri());
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $this->response->setContent('404 - Page not found');
                $this->response->setStatusCode(404);
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $response->setContent('405 - Method not allowed');
                $response->setStatusCode(405);
                break;
            case \FastRoute\Dispatcher::FOUND:
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
