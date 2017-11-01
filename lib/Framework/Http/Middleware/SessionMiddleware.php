<?php

namespace Lib\Framework\Http\Middleware;

use Lib\Framework\Session;

class SessionMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     **/
    public function __invoke($request, $response, $next = null)
    {
        if (!Session::$sessionStarted) {
            Session::start();
            $name = Session::set('name', 'guest');
        }

        $response->getBody()->write(' Testing session started before controller or route '); //this is here for testing, to show that the session middleware is called before output
        $response = $next($request, $response);
        return $response;
    }
}
