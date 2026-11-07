<?php

namespace ChassisPHP\Framework;

use Dotenv\Dotenv;

class EnvVarsLoader
{
    private static $envVars;

    public static function loadEnvVars()
    {
        if (static::$envVars === null) {
            $path = APP_ROOT;
            // The unsafe loader also calls putenv(), so getenv() and envar() keep working
            $loader = Dotenv::createUnsafeImmutable($path);
            static::$envVars = $loader->load();
        }
        return static::$envVars;
    }
}
