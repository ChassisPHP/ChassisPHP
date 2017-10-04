<?PHP


return [
/*
 * These are the routes for your frontend
 * This file contains your application
 * frontend, public-facing routes
 */
    ['GET', '/', ['HomeController', 'index']],

    ['GET', '/new', function () {
        echo 'This is a test page!';
    }],

    ['GET', '/test', function () {
        echo $this->container->get('Twig')->render('test.html.twig');
        return true;
    }],

    ['GET', '/name/{name}', ['NameController', 'show']],

    ['GET', '/errors/404', function () {
        echo 'Dude - there aint no setch page<br>That\'s a 404';
    }],

];
