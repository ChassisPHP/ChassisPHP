<?php

use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;

// Get the value of a .env variable
// If the variable is not set, use the default
if (! function_exists('envar')) {
    function envar($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

//debug tool for examining variables
if (! function_exists('debugVar')) {
    function debugVar($var)
    {
        $dumper = new HtmlDumper;
        $cloner = new VarCloner;
        $dumper->dump($cloner->cloneVar($var));
        die();
    }
}

// Get the site base URL
if (! function_exists('baseURL')) {
    function baseURL()
    {
        $url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        return $url;
    }
}

// Returns the path to the storage folder
if (! function_exists('storagePath')) {
    /**
     * Path string to storage folder, when passed with appended $path
     *
     * @param string $path
     * @return string
     */
    function storagePath($path = '')
    {
        $basePath = dirname(__DIR__, 2);
        return $basePath . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (! function_exists('logTo')) {
    /**
     * Delegates logging to the registered Logger.
     *
     * @param $level
     * @param $message
     * @param array $context
     */
    function logTo($level, $message, $context = [])
    {
        // TODO avoid creating a new container for every log entry
        (new \Lib\Framework\Container)->get('Logger')->log($level, $message, $context);
    }
}
