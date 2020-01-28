<?php

namespace ChassisPHP\Framework\Http;

use ChassisPHP\Framework\Http\MiddlewareQueue;
use ChassisPHP\Framework\Services\Mailer;
use ChassisPHP\Framework\Container;
use ChassisPHP\Framework\Session;

class Controller
{
    protected $middlewareQueue;
    protected $middleware;
    protected $connection;
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

    // inject the DB connection
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
