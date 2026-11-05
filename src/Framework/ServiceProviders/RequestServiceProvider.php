<?php

namespace ChassisPHP\Framework\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Laminas\Diactoros\ServerRequestFactory;

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
