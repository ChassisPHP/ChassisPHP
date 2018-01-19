<?php

namespace Lib\Framework;

use Dotenv\Dotenv;

class EnvVarsLoader
{
    private static $envVars;

    public static function loadEnvVars()
    {
        if (static::$envVars === null) {
            $path = dirname(__FILE__, 3);
            $loader = new Dotenv($path . DIRECTORY_SEPARATOR);
            static::$envVars = $loader->load();
        }
        return static::$envVars;
    }
}
