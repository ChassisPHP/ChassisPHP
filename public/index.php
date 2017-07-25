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


    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Lib\Framework\Core;
    use Lib\Framework\Router;

    $request = Request::createFromGlobals();                 

    // Use the Core to bootstrap an app
    $app = new Core($request);


    $app->addRoute('GET','/', function () {
            return new Response('This is the home page!');
        }
    );
    $app->addRoute('GET', '/about', function ()
    {
        return new Response('This is the about page!');
    });
    $app->addRoute('GET', '/name/{name}', function ($name)
    {
        return new Response('Well, Hello ' . $name);
    });
    $app->addRoute('GET', '/test', function ()
    {
        return new Response('Roger\'s test page?');
    });
    $app->addRoute('GET', '/errors/404', function ()
    {
        return new Response('Dude - there aint no setch page<br>That\'s a 404');
    });
    $response = $app->run();
    
    echo $response;
