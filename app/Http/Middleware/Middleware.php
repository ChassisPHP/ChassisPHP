<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Middleware
{
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        if (!$next) {
            return $response;
        }

        // Determine if user is logged in
        // TODO write function to check
        // if user is logged in
        // and possibly check user level

        return $response;
    }
}
