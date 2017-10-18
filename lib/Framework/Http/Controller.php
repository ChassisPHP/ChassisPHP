<?php

namespace Lib\Framework\Http;

use Lib\Framework\Http\MiddlewareQueue;
use Lib\Framework\Container;

class Controller
{
    protected $middlewareQueue;

    public function __construct(MiddlewareQueue $middlewareQueue)
    {
        $this->middlewareQueue = $middlewareQueue;
    }

    protected function addMiddleware($middleware)
    {
        $this->middlewareQueue->addMiddleware($middleware);
    }
}
