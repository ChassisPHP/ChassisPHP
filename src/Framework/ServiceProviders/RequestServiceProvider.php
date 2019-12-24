<?php

namespace Lib\Framework\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\ServerRequestFactory;

/*
 *  ServiceProvider to implement PSR-7 request object
 */
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
