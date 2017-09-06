<?PHP

use Symfony\Component\HttpFoundation\Response;

return [
/*
 * These are the routes for your backend
 * This file contains your application
 * backenend, admin pages routes
 */
    ['GET', '', function () {
        echo 'This is the backend front page!';
    }],

    ['GET', '/users', function () {
        echo 'This is the users management page!';
    }],

    ['GET', '/test', function () {
        echo 'This is Roger\'s test page';
    }],
];
