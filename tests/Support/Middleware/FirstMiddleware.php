<?php

namespace Tests\Support\Middleware;

// Records that it ran by writing to the response body, then passes on
class FirstMiddleware
{
    public function __invoke($request, $response, $next = null)
    {
        $response->getBody()->write('first;');
        return $next($request, $response);
    }
}
