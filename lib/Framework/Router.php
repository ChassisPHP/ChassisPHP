<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

namespace Lib\Framework;

use FastRoute\RouteCollector;

class Router
{
    
    private $dispatcher;

    public function __construct()
    {
        //
    }

    public function getRouteInfo($request, $routeDefinitionCallback)
    {
        $dispatcher = $this->dispatcher($routeDefinitionCallback);
        $requestURI = $request->getRequestUri();
        
        // if the route has a trainling /, remove it
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
}
