<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\ServiceProviders\ControllerServiceProvider;

class ControllerServiceProviderTest extends TestCase
{
    public function testProvidesControllersAndSubdirectoryControllers()
    {
        $provider = new ControllerServiceProvider();

        $this->assertTrue($provider->provides('App\Http\Controllers\HomeController'));
        $this->assertTrue($provider->provides('App\Http\Controllers\Backend\AuthController'));
        $this->assertFalse($provider->provides('App\Http\Controllers\MissingController'));
    }
}
