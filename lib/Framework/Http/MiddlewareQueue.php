<?php

namespace Lib\Framework\Http;

use SplDoublyLinkedList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareQueue
{
    protected $queue;
    protected $response;
    protected $request;
    
    // set up our middleware queue as a DoubleLinkedList
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->queue = new SplDoublyLinkedList;
        $this->response = $response;
        $this->request = $request;
    }

    // add middleware to the queue
    public function addMiddleware($middleware)
    {
        // if the queue is empty, handle it
        if ($this->queue->isEmpty()) {
            $this->startQueue($this->response);
        }

        $this->queue->rewind();
        $this->next = $this->queue->current();
        $middleware = '\Http\Middleware\\'.$middleware;
        $this->middleware = new $middleware;
        $this->queue[] = function (
            ServerRequestInterface $request,
            ResponseInterface $response
        ) {
            $result = call_user_func($this->middleware, $request, $response, $this->next);
            return $result;
        };

        return $this->queue;
    }

    private function startQueue()
    {
        $this->queue[] = function ($request, $response) {
            return $response;
        };
        return;
    }

    public function callMiddleware(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (! $this->queue->isEmpty()) {
            $this->queue->rewind();
            $next = $this->queue->pop();
            $response = $next($request, $response);
            return $response;
        }
        return $response;
    }
}
