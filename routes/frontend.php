<?php

return [
/*
 * These are the routes for your frontend
 * This file contains your application
 * frontend, public-facing routes
 */
    ['GET', '/', ['HomeController', 'index']],
    ['GET', '/about', ['AboutController', 'index']],

    ['GET', '/new', function () {
        return 'This is a test page!';
    }],

    ['GET', '/test', function () {
        return $this->container->get('Twig')->render('test.html.twig');
    }],

    ['GET', '/name/{name}', ['NameController', 'show']],

    ['GET', '/errors/404', function () {
        return $this->container->get('Twig')->render('/errors/404.html');
    }],

    ['GET', '/errors/general', function () {
        return $this->container->get('Twig')->render('/errors/error.html');
    }],
];
