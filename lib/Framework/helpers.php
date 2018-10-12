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

// Redirect the user.
if (! function_exists('redirectPath')) {
    function redirectPath($path = '/', $code = 301)
    {
        $url = sprintf("%s%s", baseURL(), ltrim($path, '/'));

        header("Location: $url", TRUE, ($code !== 301) ? 302 : 301);
        exit;
    }
}