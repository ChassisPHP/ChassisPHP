<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

namespace Lib\Framework;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Router
{
    
    private $dispatcher;
    public $response;

    public function __construct()
    {
        $this->response = new Response;
    }

    public function getRouteInfo($request, $routeDefinitionCallback)
    {
        $dispatcher = $this->dispatcher($routeDefinitionCallback);
        $requestURI = $request->getRequestUri();

      // if the route has a trailing /, remove it
        if (strlen($requestURI)>1) {
            $requestURI = rtrim($requestURI, "/");
        }
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $requestURI);

        return $routeInfo;
    }

    private function dispatcher($routeDefinitionCallback)
    {
        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
        return $dispatcher;
    }

    // dispatch a response
    public function dispatch($request, $routeDefinitionCallback)
    {
        $routeInfo = $this->getRouteInfo($request, $routeDefinitionCallback);
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
                if (is_array($routeInfo[1])) {
                    $classname = $routeInfo[1][0];
                    $classname = 'Http\Controllers\\' . $classname;
                    $method = $routeInfo[1][1];
                    $vars = $routeInfo[2];
                    $class = new $classname;
                    $class->$method($vars);
                } else {
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    call_user_func($handler, $vars);
                }
                break;
        }
        return $this->response;
    }
}
