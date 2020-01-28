<?php

namespace ChassisPHP\Framework\ServiceProviders;

use Zend\Diactoros\Response;
use League\Container\ServiceProvider\AbstractServiceProvider;

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
