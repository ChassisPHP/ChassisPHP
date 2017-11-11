<?php

namespace Lib\Framework\Http;

use Lib\Framework\Http\MiddlewareQueue;
use Lib\Framework\Container;

class Controller
{
    protected $middlewareQueue;
    protected $middleware;
    protected $request;
    protected $view;

    public function __construct()
    {
        //
    }

    protected function addMiddleware($middleware)
    {
        $this->middlewareQueue->addMiddleware($middleware);
    }

    // inject the Request
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    // inject the MiddlewareQueue
    public function setMiddlewareQueue($middlewareQueue)
    {
        $this->middlewareQueue = $middlewareQueue;
    }
    
    // inject Twig
    public function setView($view)
    {
        $this->view = $view;
    }
}
