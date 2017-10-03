<?PHP

/**
 *  ChassisPHP - A PHP framework designed for CMS
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

// set session storage location and
// start the session
ini_set('session.save_path', dirname(__FILE__, 3) . '/storage/sessions');
ini_set('session.gc_probability', 1);
session_start();

// set up the application
$app = new \Lib\Framework\Core();

$response = $app->run();