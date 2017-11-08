<?php

return [
/*
 * These are the routes for your backend
 * This file contains your application
 * backenend, admin pages routes
 */
    ['GET', '', function () {
        return 'This is the backend front page!';
    }],

    ['GET', '/register', ['Backend\AuthController', 'create']],
    ['POST', '/register', ['Backend\AuthController', 'store']],

    ['GET', '/users', ['Backend\AuthController', 'index']],

    ['GET', '/test', function () {
        return 'This is Roger\'s test page';
    }],
];
