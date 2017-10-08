<?php

/*
 *  ServiceProvider to implement PSR-7 request object
 */

namespace App\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\ServerRequestFactory;

class RequestServiceProvider extends AbstractServiceProvider
{
    protected $provides = ['PsrRequestInterface'];

    public function register()
    {
        $this->getContainer()->add('PsrRequestInterface', function () {
            $psrRequest = ServerRequestFactory::fromGlobals();
            return $psrRequest;
        });
    }
}
