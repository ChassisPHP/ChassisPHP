<?php

/**
 * ChassisPHP - A PHP framework designed for CMS
 *
 * @package ChassisPHP
 * @copyright Copyright (c) 2017 Roger Creasy
 * @author  Roger Creasy <roger@chassisPHP.com>
 * @license https://github.com/RogerCreasy/ChassisPHP/blob/master/LICENSE
 */

// set a constant with the time we are starting
define('CHASSIS_START', microtime(true));

// crank up the Composer autoloading
require __DIR__.'/../vendor/autoload.php';

// load environment variables
\Lib\Framework\EnvVarsLoader::loadEnvVars();

// set session storage location and
// start the session
ini_set('session.save_path', dirname(__FILE__, 2) . '/storage/sessions');
ini_set('session.gc_probability', \Lib\Framework\ConfigManager::get('app.gcProb'));
session_start();

// set the timeout for the session
$timeout = envar('SESSION_TIMEOUT', 1800);

if (isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {
        // Destroy the session and restart it.
        session_destroy();
        session_start();
    }
}

// Update the timout field with the current time.
$_SESSION['timeout'] = time();

// Handle Fatal Errors
require __DIR__ . '/../lib/Framework/Handlers/FatalErrorHandler.php';
$fatalErrorHandler = new \Lib\Framework\Handlers\FatalErrorHandler;
register_shutdown_function(array($fatalErrorHandler, 'fatalErrorHandler'));

// set up the application
$app = new \Lib\Framework\Core();

$app->run();
