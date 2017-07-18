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
        //$this->router = new RouteCollector();
        $this->request = $request;
        
        // Crank up the Router
        $this->router = new Router();
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

    public function dispatch()
    {
        $dispatcher = new Dispatcher($this->router->getData());
        try {
            $output = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());
        } catch (HttpRouteNotFoundException $e) {
            $output = $dispatcher->dispatch('GET', '/errors/404');
        } catch (HttpMethodNotAllowedException $e) {
            $output = '400';
        }

        return $output;
    }

/*    $dispatcher = new Phroute\Dispatcher($router);

    try {
         $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], processInput($_SERVER['REQUEST_URI']));
    } catch (Phroute\Exception\HttpRouteNotFoundException $e) {
      var_dump($e);
      die();
    } catch (Phroute\Exception\HttpMethodNotAllowedException $e) {
      var_dump($e);
      die();
    }
    echo $response; */
}
