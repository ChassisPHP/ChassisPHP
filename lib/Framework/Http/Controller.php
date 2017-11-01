<?php

namespace Lib\Framework\Http;

use Lib\Framework\Http\MiddlewareQueue;
use Lib\Framework\Container;

class Controller
{
    protected $middlewareQueue;
    protected $twig;

    public function __construct(MiddlewareQueue $middlewareQueue, \Twig_Environment $twig)
    {
        $this->middlewareQueue = $middlewareQueue;
        $this->twig = $twig;
    }

    protected function addMiddleware($middleware)
    {
        $this->middlewareQueue->addMiddleware($middleware);
    }
}
