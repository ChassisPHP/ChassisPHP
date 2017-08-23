<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

namespace Lib\Framework;

use Fastroute\Dispatcher;

class Router extends RouteCollector
{
    public $dispatcher;

    public function __construct()
    {
        Parent::__construct();
        $this->dispatcher = new Dispatcher;
    }
}
