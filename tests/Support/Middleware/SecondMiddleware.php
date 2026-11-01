<?php

namespace Tests\Support\Middleware;

// Records that it ran by writing to the response body, then passes on
class SecondMiddleware
{
    public function __invoke($request, $response, $next = null)
    {
        $response->getBody()->write('second;');
        return $next($request, $response);
    }
}
