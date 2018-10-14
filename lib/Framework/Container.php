<?php

namespace Lib\Framework;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Lib\Framework\Log\LogManager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Lib\Database\Connection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Lib\Framework\Http\Controller;
use App\Http\Controllers\Backend\AuthController;

class Container extends LeagueContainer
{
    public function __construct()
    {
        parent::__construct();

        // register the reflection container as a delegate to enable auto wiring
        $this->delegate(
            new ReflectionContainer
        );

        $this->addServiceProvider('App\ServiceProviders\ResponseServiceProvider');
        $this->addServiceProvider('App\ServiceProviders\RequestServiceProvider');

        // Add developer controllers
        $this->addServiceProvider('Lib\Framework\Container\ControllerServiceProvider');

        $this->share('MiddlewareQueue', new \Lib\Framework\Http\MiddlewareQueue($this->get('PsrRequestInterface'), $this->get('PsrResponseInterface')));

        $this->add('Router', function () {
            $request = $this->get('PsrRequestInterface');
            $response = $this->get('PsrResponseInterface');
            $middlewareQueue = $this->get('MiddlewareQueue');
            $router = new Router($request, $response, $middlewareQueue);
            return $router;
        });

        //set the base directory
        $this->add('BaseDir', function () {
            $baseDir = dirname(__FILE__, 3);
            return $baseDir;
        });

        $this->add('Dotenv', function () {
            return EnvVarsLoader::loadEnvVars();
        });

        $this->add('Connection', function () {
            $connection = new Connection();
            return $connection;
        });

        $this->add('Config', function () {
            return ConfigManager::instance();
        });

        $this->add('Logger', function () {
            return new LogManager($this);
        });

        $this->add('Twig', function () {
            $loader = new \Twig_Loader_Filesystem(dirname(__FILE__, 3) . '/resources/views');
            $twig = new \Twig_Environment($loader, array(
               'cache' => dirname(__FILE__, 3) . '/storage/compiledviews',
               'auto_reload' => true,
               'debug' => false,
            ));
            //$twig->addExtension(new \Twig_Extension_Debug());
            return $twig;
        }, true);

        // Add additional default error pages here.
        $this->add('template.defaults.404', 'errors/404.twig');
    }
}
