<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

namespace Lib\Framework;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\GroupCountBased;

class Router
{
    /*
    private $routeParser;
    private $dataGenerator;
    private $routeCollector;
    private $response;

    public function __construct()
    {
        $this->routeParser = new Std;
        $this->dataGenerator = new GroupCountBased;
        $this->routeCollector = new RouteCollector($this->routeParser, $this->dataGenerator);
        $this->response = new Response;
    }

    public function addRoute($method, $route, $handler)
    {
        $this->routeCollector->addRoute($method, $route, $handler);
    }

    public function dispatch($request, $routeCollection)
    {
        return $this->response;
    }
     */
}
