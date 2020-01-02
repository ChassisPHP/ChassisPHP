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
    protected $key;

    // set up our middleware queue as a DoubleLinkedList
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->queue = array();
        $this->response = $response;
        $this->request = $request;
    }

    // add middleware to the queue
    public function addMiddleware($middleware, $middlewareDir = '\App\Http\Middleware\\')
    {
        //if the queue is empty, handle it
       // if (empty($this->queue)) {
         //   $this->startQueue();
       // }

        $middleware = $middlewareDir . $middleware;
        $callable = new $middleware;
        array_push($this->queue, $callable);

        return $this->queue;
    }

    private function startQueue()
    {
        $this->queue[0] = null;

        return;
    }

    public function getQueue()
    {
        $c = array();
        foreach ($this->queue as $k => $v) {
            $c[$k] = $v;
        }
        debugVar($c);
    }

    public function addController($classResponse)
    {
        // add string content to response via controllerMiddleware object
        $controller = '\Lib\Framework\Http\Middleware\ControllerMiddleware';
        $callable = new $controller($classResponse);
        array_unshift($this->queue, $callable);
    }

    public function callMiddleware(ServerRequestInterface $request, ResponseInterface $response)
    {
        $middlewareStack = $this->traverseMiddleware();

        $middlewareStack->rewind();
        $start = $middlewareStack->top();
        
        $response = $start($request, $response);
    
        return $response;
    }

    private function traverseMiddleware()
    {
        $stack = new SplDoublyLinkedList;
        foreach ($this->queue as $key => $middleware) {
            if ($key == 0) {
                $next = null;
            } else {
                $stack->rewind();
                $next = $stack->top();
            }
            
            $stack->push(function (
                ServerRequestInterface $request,
                ResponseInterface $response
            ) use (
                $middleware,
                $next
            ) {
                $result = call_user_func($middleware, $request, $response, $next);
                return $result;
            });
        }
        return $stack;
    }
}
