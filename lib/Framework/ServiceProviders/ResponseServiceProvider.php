<?php

namespace Lib\Framework\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\Response;

/*
 *  ServiceProvider to implement PSR-7 response object
 */
class ResponseServiceProvider extends AbstractServiceProvider
{
    protected $provides = ['PsrResponseInterface'];

    public function register()
    {
        $this->getContainer()->add('PsrResponseInterface', function () {
            return new Response();
        });
    }
}
