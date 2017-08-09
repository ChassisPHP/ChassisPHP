<?PHP

/**
 *  ChassisPHP - A PHP framework designed for CMS
 *
 * @package ChassisPHP
 * @copyright Copyright (c) 2017 Roger Creasy
 * @author  Roger Creasy <roger@chassisPHP.com>
 * @license https://github.com/RogerCreasy/ChassisPHP/blob/master/LICENSE
 */

//do the autoloading stuff
require __DIR__.'/../lib/Framework/startApp.php';

    use Symfony\Component\HttpFoundation\Response;
    use Lib\Framework\Container;

    $container = new Container;

    // Use the Core to bootstrap an app
    $app = $container->get('Core');

    $response = $app->run();
    
    echo $response;
