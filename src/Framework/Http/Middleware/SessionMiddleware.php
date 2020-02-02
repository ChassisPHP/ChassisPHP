<?php

namespace ChassisPHP\Framework\Http\Middleware;

use ChassisPHP\Framework\Session;

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
            $userid = Session::get('user');
            if (!$userid) {
                Session::set('user', 'guest');
            }
        }

        $response = $next($request, $response);
        return $response;
    }
}
