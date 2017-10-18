<?php

/*
 *  ServiceProvider to implement PSR-7 response object
 */

namespace App\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\Response;
use Http\Controllers\Backend\UserController;

class UserControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = ['UserController'];

    public function register()
    {
        $middlewareQueue = $this->getContainer()->get('MiddlewareQueue');
        $this->getContainer()->add('Http\Controllers\Backend\UserController')
             ->withArgument($middlewareQueue);
    }
}
