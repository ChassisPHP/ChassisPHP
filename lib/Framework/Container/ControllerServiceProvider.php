<?php

namespace Lib\Framework\Container;

use League\Container\ServiceProvider\AbstractServiceProvider;

/**
* This class automatically adds
* all of your controllers
*/
class ControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [];

    public function __construct()
    {
        // loop through the controllers directory and
        // add the namespace of each controller
        // to the provides array
        $this->provides = $this->readInControllers();
    }

    public function register()
    {
        // logic in registerControllers could be included here
        // This is done this way to maintain the structure created
        // by The PHP League. Maybe not neccessary?
        $this->registerControllers();
    }

    // read in the controllers and convert location to namespace
    // for $this->provides
    private function readInControllers()
    {
        $provides = [];
        $baseDir = dirname(__FILE__, 4);
        $baseNamespace = "App\Http\Controllers\\";
        $controllerDir = $baseDir . "/app/Http/Controllers/*";
        foreach (glob($controllerDir) as $subElement) {
            // if our subElement is a directory
            // we need to explore its contents
            if (is_dir($subElement)) {
                $subDir = $subElement . "/*.php";
                foreach (glob($subDir) as $controller) {
                    $controllerNamespace = $baseNamespace . basename($subElement) . "\\" . basename($controller, ".php");
                    array_push($provides, $controllerNamespace);
                }
            } else {
                // the sub-element in the controller directory is a controller, not a sun-dir
                $controllerNamespace = $baseNamespace . basename($subElement, ".php");
                array_push($provides, $controllerNamespace);
            }
        }
        return $provides;
    }

    // loop through $this->provides and register controllers
    private function registerControllers()
    {
        foreach ($this->provides as $controller) {
            $this->getContainer()->add($controller)
                ->withMethodCall(
                    'setMiddlewareQueue',
                    [
                       $this->getContainer()->get('MiddlewareQueue')
                    ]
                )
                ->withMethodCall(
                    'setRequest',
                    [
                       $this->getContainer()->get('PsrRequestInterface')
                    ]
                )
                ->withMethodCall(
                    'setView',
                    [
                       $this->getContainer()->get('Twig')
                    ]
                )
                ->withMethodCall(
                    'addMiddleware',
                    []
                );
        }
    }
}
