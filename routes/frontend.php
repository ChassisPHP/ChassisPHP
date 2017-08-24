<?PHP


return [
/*
 * These are the routes for your frontend
 * This file contains your application
 * frontend, public-facing routes
 */
    ['GET', '/', ['Http\Controllers\HomeController', 'index']],

    ['GET', '/new', function () {
        echo 'This is a test page!';
    }],

    ['GET', '/test', function () {
        echo 'This is Roger\'s test page';
    }],

    ['GET', '/name/{name}', ['Http\Controllers\NameController', 'show']],

    ['GET', '/errors/404', function () {
        echo 'Dude - there aint no setch page<br>That\'s a 404';
    }],

];
