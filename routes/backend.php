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


    ['GET', '/users', ['Backend\UserController', 'index']],
    ['GET', '/users/register', ['Backend\UserController', 'create']],
    ['POST', '/users/register', ['Backend\UserController', 'store']],
    ['GET', '/users/delete/{ID}', ['Backend\UserController', 'destroy']],

    ['GET', '/login', ['Backend\AuthController', 'index']],
    ['POST', '/login', ['Backend\AuthController', 'store']],

    ['GET', '/test', function () {
        return 'This is Roger\'s test page';
    }],
];
