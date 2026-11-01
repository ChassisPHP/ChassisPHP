<?php

return [
    ['GET', '/', ['HomeController', 'index']],
    ['GET', '/hello/{name}', function ($vars) {
        return 'Hello ' . $vars['name'];
    }],
    ['POST', '/form', function ($vars) {
        return 'posted';
    }],
];
