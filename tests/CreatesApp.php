<?php

namespace Tests;

trait CreatesApp
{
    /**
     * Start an instance of ChassisPHP
     * for testing
     **/
    public function createApplication()
    {

        //crank up the Composer autoloading
        require dirname(__FILE__, 2) . '/vendor/autoload.php';

        //set up the application
        $app = new \Lib\Framework\Core();

        return $app;
    }
}
