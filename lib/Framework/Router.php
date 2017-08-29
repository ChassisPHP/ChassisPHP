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


    public function dispatcher($routeDefinitionCallback)
    {
        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
        return $dispatcher;
    }
}
