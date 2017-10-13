<?php

namespace Lib\Framework;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Lib\Database\Connection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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

        $this->add('Router', function () {
            $response = $this->get('PsrResponseInterface');
            $router = new Router($response);
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
            $config = $this->get('Config');
            $connection = new Connection($config);
            return $connection;
        });

        $this->add('Config', function () {
            $config = new Config;
            return $config;
        });

        $this->add('Logger', function () {
            $log = new Logger('CHASSISPHP');
            $log->pushHandler(new StreamHandler(dirname(__FILE__, 3) . 'Storage/logs/app.log', LOGGER::DEBUG));
        });

        $this->add('Twig', function () {
            $loader = new \Twig_Loader_Filesystem(dirname(__FILE__, 3) . '/resources/views');
            return $twig = new \Twig_Environment($loader, array(
                'cache' => dirname(__FILE__, 3) . '/storage/compiledviews',
                'auto_reload' => true,
            ));
        }, true);

        // Add additional default error pages here.
        $this->add('template.defaults.404', 'errors/404.twig');
    }
}
