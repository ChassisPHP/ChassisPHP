<?PHP

use Symfony\Component\HttpFoundation\Response;

return [
/*
 * These are the routes for your backend
 * This file contains your application
 * backenend, admin pages routes
 */
    ['GET', '/backend', function () {
        echo 'This is the backend front page!';
    }],

    ['GET', '/backend/users', function () {
        echo 'This is the users management page!';
    }],

    ['GET', '/backend/test', function () {
        echo 'This is Roger\'s test page';
    }],
];
