<?php

namespace Lib\Framework;

use Dotenv\Dotenv;

class EnvVarsLoader
{
    private static $envVars;

    public static function loadEnvVars()
    {
        if (static::$envVars === null) {
            $loader = new Dotenv(dirname(__FILE__, 3), '.env');
            static::$envVars = $loader->load();
        }
        return static::$envVars;
    }
}