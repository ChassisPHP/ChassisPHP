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
        //set up the application
        $app = new \ChassisPHP\Framework\Core();

        return $app;
    }
}
