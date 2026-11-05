<?php

error_reporting(E_ALL);

// PHPUnit knows which autoloader it was started with
require defined('PHPUNIT_COMPOSER_INSTALL') ? PHPUNIT_COMPOSER_INSTALL : dirname(__DIR__) . '/vendor/autoload.php';

// The framework reads config, routes, controllers and views relative to APP_ROOT,
// so point it at a minimal application used only by the tests
define('APP_ROOT', __DIR__ . '/fixtures/app');

// Autoload the fixture application's App\ namespace
spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') === 0) {
        $path = APP_ROOT . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }
});

// Sessions in the CLI: don't try to send cookies or cache headers
ini_set('session.use_cookies', '0');
ini_set('session.cache_limiter', '');
ini_set('session.save_path', sys_get_temp_dir());

// Values a web server always provides
$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ?? 'localhost';
