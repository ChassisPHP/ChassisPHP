<?PHP

namespace Tests;

use Lib\Framework\Container;

trait StartApp
{
    /**
     * Start an instance of ChassisPHP
     * for testing
     **/
    public function StartInstance ()
    {
        $container = new Container;

        // Use the Core to bootstrap an app
        $app = $container->get('Core');

        return $app;
    }
}

