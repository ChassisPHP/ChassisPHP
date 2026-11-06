<?php

namespace Tests\Support\Middleware;

// Stops the request, so nothing after it in the queue runs
class BlockingMiddleware
{
    public function __invoke($request, $response, $next = null)
    {
        return $response->withStatus(403);
    }
}
