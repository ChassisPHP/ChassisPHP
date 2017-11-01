<?php

namespace Lib\Framework\Http\Middleware;

use Lib\Framework\ResponseBody;

class ControllerMiddleware
{
    private $classResponse;

    public function __construct($classResponse)
    {
        $this->classResponse = $classResponse;
    }

    /**
     *  middleware invokable class
     *  this class allows the controller
     *  response to be placed in the middleware stack
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     **/
    public function __invoke($request, $response, $next = null)
    {
        $response->getBody()->write(ResponseBody::createFromString($this->classResponse));
        return $response;
    }
}
