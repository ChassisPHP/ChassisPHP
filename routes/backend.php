<?PHP

use Symfony\Component\HttpFoundation\Response;

return [
/*
 * These are the routes for your backend
 * This file contains your application
 * backenend, admin pages routes
 */
    ['GET', '/', function () {
        return new Response('This is the backend front page!');
    }],

    ['GET', '/users', function () {
        return new Response('This is the users management page!');
    }],

    ['GET', '/test', function () {
        return new Response('This is Roger\'s test page');
    }],

    ['GET', '/name/{name}', function ($name) {
        return new Response('Well, hello ' . $name .'!');
    }],
];
