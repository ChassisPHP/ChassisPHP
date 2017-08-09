<?PHP

namespace Lib\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Lib\Framework\Router;
use Phroute\Phroute\Dispatcher;

class Core implements HttpKernelInterface
{

    protected $router;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        
        // Crank up the Router
        $this->router = new Router();
        $this->readRoutes();
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

    public function addRoute($method, $route, $function)
    {
        $this->router->addRoute($method, $route, $function);
    }

    public function readRoutes()
    {
        $routes = include('../routes/frontend.php');
        foreach ($routes as $route) {
            $this->addRoute($route[0], $route[1], $route[2]);
        }
    }
    // Generate the response
    public function run()
    {
        $dispatcher = new Dispatcher($this->router->getData());
        try {
            $response = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());
        } catch (HttpRouteNotFoundException $e) {
            $response = $dispatcher->dispatch('GET', '/errors/404');
        } catch (HttpMethodNotAllowedException $e) {
            $response = '400';
        }

        return $response;
    }
}
