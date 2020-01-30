<?php

namespace Lib\Framework;

use Dotenv\Dotenv;

class EnvVarsLoader
{
    private static $envVars;

    public static function loadEnvVars()
    {
        if (static::$envVars === null) {
            $path = APP_ROOT;
            $loader = new Dotenv($path . DIRECTORY_SEPARATOR);
            static::$envVars = $loader->load();
        }
        return static::$envVars;
    }
}
