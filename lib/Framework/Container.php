<?php

namespace Lib\Framework;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use Symfony\Component\HttpFoundation\Request;
use Lib\Framework\Core;

class Container extends LeagueContainer
{
    public function __construct()
    {
        parent::__construct();
 
        // register the reflection container as a delegate to enable auto wiring
        $this->delegate(
            new ReflectionContainer
        );

        $this->add('Request', function () {
            $request = new Request;
            return $request->createFromGlobals();
        });

        //set the base directory
        $this->add('BaseDir', function () {
            $baseDir = dirname(__FILE__, 3);
            return $baseDir;
        });
    }
}
