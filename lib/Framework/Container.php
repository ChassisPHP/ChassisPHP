<?php

namespace Lib\Framework;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lib\Framework\Core;
use Lib\Framework\Router;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Lib\Database\Connection;
use Lib\Framework\Config;
use Psr\Log\LoggerInterface;

class Container extends LeagueContainer
{
    public function __construct(LoggerInterface $logger = null)
    {
        parent::__construct();

        // register the reflection container as a delegate to enable auto wiring
        $this->delegate(
            new ReflectionContainer
        );

        $this->add('Request', function () {
            $request = new Request;
            return $request->createFromGlobals();
        });

        $this->add('Response', function () {
            $response = new Response;
            return $response;
        });

        $this->add('Router', function () {
            $response = $this->get('Response');
            $router = new Router($response);
            return $router;
        });

        //set the base directory
        $this->add('BaseDir', function () {
            $baseDir = dirname(__FILE__, 3);
            return $baseDir;
        });

        $this->add('Dotenv', function () {
            $dotenv = new Dotenv(dirname(__FILE__, 3), '.env');
            return $dotenv->load();
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

        $this->add('Logger', function() {
           return $logger;
        });
    }
}
