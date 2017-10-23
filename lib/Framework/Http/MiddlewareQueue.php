<?php

namespace Lib\Framework\Http;

use SplDoublyLinkedList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Lib\Framework\ResponseBody;

class MiddlewareQueue
{
    protected $queue;
    protected $response;
    protected $request;
    protected $next;
    protected $middleware;

    // set up our middleware queue as a DoubleLinkedList
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->queue = new SplDoublyLinkedList;
        $this->response = $response;
        $this->request = $request;
    }

    // add middleware to the queue
    public function addMiddleware($middleware, $middlewareDir = '\App\Http\Middleware\\')
    {
        //if the queue is empty, handle it
        if ($this->queue->isEmpty()) {
            $this->startQueue();
        }

        $next = $this->queue->top();
        $middleware = $middlewareDir . $middleware;
        $callable = new $middleware;
        $this->queue->push(function (
            ServerRequestInterface $request,
            ResponseInterface $response
        ) use (
            $callable,
            $next
        ) {
            $result = call_user_func($callable, $request, $response, $next);
            return $result;
        });

        return $this->queue;
    }

    private function startQueue()
    {
        $this->queue->push(function (ServerRequestInterface $request, ResponseInterface $response) {
            return $response;
        });

        return;
    }

    public function getQueue()
    {
        return $this->queue;
    }

    public function addController($classResponse)
    {
        //if the queue is empty, handle it
        if ($this->queue->isEmpty()) {
            $this->startQueue();
        }

        $next = $this->queue->top();
        $this->queue->push(function (
            ServerRequestInterface $request,
            ResponseInterface $response
        ) use (
            $classResponse,
            $next
        ) {
            $response = $response->withBody(ResponseBody::createFromString($classResponse));
            return $next($request, $response);
        });
    }

    public function callMiddleware(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (!$this->queue->isEmpty()) {
            $next = $this->queue->top();
            $response = $next($request, $response);
            return $response;
        }

        return $response;
    }
}
