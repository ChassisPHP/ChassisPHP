<?PHP

return [
/*
 * These are the routes for your backend
 * This file contains your application
 * backenend, admin pages routes
 */
    ['GET', '', function () {
        echo 'This is the backend front page!';
    }],

    ['GET', '/users', ['Backend\UserController', 'index']],

    ['GET', '/test', function () {
        echo 'This is Roger\'s test page';
    }],
];
