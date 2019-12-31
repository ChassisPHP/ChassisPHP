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

    // Content
    ['GET', '/content', ['Backend\ContentController', 'index']],
    ['GET', '/content/create', ['Backend\ContentController', 'create']],
    ['POST', '/content/create', ['Backend\ContentController', 'store']],
    ['GET', '/content/update/{ID}', ['Backend\ContentController', 'edit']],
    ['POST', '/content/update/{ID}', ['Backend\ContentController', 'update']],
    ['GET', '/content/{ID}', ['Backend\ContentController', 'select']],
    ['GET', '/content/delete/{ID}', ['Backend\ContentController', 'destroy']],

    // Images
    ['GET', '/images', ['Backend\ImageController', 'index']],
    ['GET', '/images/create', ['Backend\ImageController', 'create']],
    ['POST', '/images/create', ['Backend\ImageController', 'store']],
    ['GET', '/images/update/{ID}', ['Backend\ImageController', 'edit']],
    ['POST', '/images/update/{ID}', ['Backend\ImageController', 'update']],
    ['GET', '/images/{ID}', ['Backend\ImageController', 'select']],
    ['GET', '/images/delete/{ID}', ['Backend\ImageController', 'destroy']],

    // Albums
    ['GET', '/albums', ['Backend\AlbumController', 'index']],
    ['GET', '/albums/create', ['Backend\AlbumController', 'create']],
    ['POST', '/albums/create', ['Backend\AlbumController', 'store']],
    ['GET', '/albums/update/{ID}', ['Backend\AlbumController', 'edit']],
    ['POST', '/albums/update/{ID}', ['Backend\AlbumController', 'update']],
    ['GET', '/albums/{ID}', ['Backend\AlbumController', 'select']],
    ['GET', '/albums/delete/{ID}', ['Backend\AlbumController', 'destroy']],

    // Auth
    ['GET', '/forgot', ['Backend\AuthController', 'forgotIndex']],
    ['POST', '/forgot', ['Backend\AuthController', 'forgotStore']],
    ['GET', '/reset/{hash}', ['Backend\AuthController', 'resetIndex']],
    ['POST', '/reset/{hash}', ['Backend\AuthController', 'resetStore']],
    ['GET', '/login', ['Backend\AuthController', 'index']],
    ['POST', '/login', ['Backend\AuthController', 'store']],
    ['GET', '/logout', ['Backend\AuthController', 'logout']],
];
