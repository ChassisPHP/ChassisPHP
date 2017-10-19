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
        if (!$next) {
            return $response;
        }

        if (Session::get('name') == null) {
            Session::start();
            $name = Session::set('name', 'guest');
        }
        $response = $next($request, $response);
        $response->getBody()->write(' Name:'. $name);

        return $next($request, $response);
    }
}
