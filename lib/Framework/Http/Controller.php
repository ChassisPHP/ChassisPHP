<?php

namespace Lib\Framework\Http;

use Lib\Framework\Http\MiddlewareQueue;
use Lib\Framework\Services\Mailer;
use Lib\Framework\Container;
use Lib\Framework\Session;

class Controller
{
    protected $middlewareQueue;
    protected $middleware;
    protected $request;
    protected $logger;
    protected $mailer;
    protected $view;

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

    //set the BaseURL var
    public function setBaseURL($url)
    {
        $this->baseURL = $url;
    }

    // inject the Mailer
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }

    // inject the Logger
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}
