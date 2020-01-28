<?php

namespace ChassisPHP\Framework;

use Dotenv\Dotenv;
use Monolog\Logger as Monolog;
use Monolog\Handler\StreamHandler;
use \PHPMailer\PHPMailer\PHPMailer;
use ChassisPHP\Framework\Connection;
use Psr\Http\Message\ResponseInterface;
use League\Container\ReflectionContainer;
use ChassisPHP\Framework\Http\Controller;
use Dotenv\Exception\InvalidPathException;
use Psr\Http\Message\ServerRequestInterface;
use ChassisPHP\Framework\Services\LogManager;
use App\Http\Controllers\Backend\AuthController;
use League\Container\Container as LeagueContainer;

class Container extends LeagueContainer
{
    public function __construct()
    {
        $this->baseDir = APP_ROOT;
        parent::__construct();

        // register the reflection container as a delegate to enable auto wiring
        $this->delegate(
            new ReflectionContainer
        );

        $this->addServiceProvider('ChassisPHP\Framework\ServiceProviders\ResponseServiceProvider');
        $this->addServiceProvider('ChassisPHP\Framework\ServiceProviders\RequestServiceProvider');

        // Add developer controllers
        $this->addServiceProvider('ChassisPHP\Framework\ServiceProviders\ControllerServiceProvider');

        // Add Developer Service Providers
        $this->addDevServiceProviders();

        $this->share(
            'MiddlewareQueue',
            new \ChassisPHP\Framework\Http\MiddlewareQueue(
                $this->get('PsrRequestInterface'),
                $this->get('PsrResponseInterface')
            )
        );

        $this->add('Router', function () {
            $request = $this->get('PsrRequestInterface');
            $response = $this->get('PsrResponseInterface');
            $middlewareQueue = $this->get('MiddlewareQueue');
            $router = new Router($request, $response, $middlewareQueue);
            return $router;
        });

        //set the base directory
        $this->add('BaseDir', function () {
            return $this->baseDir;
        });

        $this->add('Dotenv', function () {
            return EnvVarsLoader::loadEnvVars();
        });

        $this->add('Connection', function () {
            $baseDir = $this->get('BaseDir');
            $connection = new Connection($baseDir);
            return $connection;
        });

        $this->add('Config', function () {
            return ConfigManager::instance();
        });

        $this->add('Logger', function () {
            $monolog = new Monolog('CHASSISPHP');
            return new LogManager($this->get('Config'), $monolog);
        });

        $this->add('Twig', function () {
            $loader = new \Twig_Loader_Filesystem($this->get('BaseDir') . '/resources/views');
            $twig = new \Twig_Environment($loader, array(
               'cache' => $this->get('BaseDir') . '/storage/compiledviews',
               'auto_reload' => true,
               'debug' => false,
            ));
            $twig->addExtension(new \Twig_Extension_Debug());
            $supportAddress = $this->get('Config')->get('mail')['supportAddress'];
            $twig->addGlobal("supportAddress", $supportAddress);
            return $twig;
        }, true);

        $this->add('Mailer', function () {
            $mailConfig = $this->get('Config')->get('mail');
            $phpMailer = new PHPMailer(true);
            $logger = $this->get('Logger');
            return new \ChassisPHP\Framework\Services\Mailer($this->get('Twig'), $mailConfig, $phpMailer, $logger);
        });

        // Add additional default error pages here.
        $this->add('template.defaults.404', 'errors/404.html');
    }

    private function addDevServiceProviders()
    {
        $providerDir = $this->baseDir . '/app/ServiceProviders/*';
        $providerNamespace = 'App\ServiceProviders\\';
        foreach (glob($providerDir) as $provider) {
            $namespace = $providerNamespace . basename($provider, '.php');
            $this->addServiceProvider($namespace);
        }
    }
}
