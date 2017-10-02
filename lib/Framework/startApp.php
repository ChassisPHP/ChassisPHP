<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

// set a constant with the time we are starting
define('CHASSIS_START', microtime(true));

// crank up the Composer autoloading
require __DIR__.'/../../vendor/autoload.php';

// set session storage location and
// start the session
ini_set('session.save_path', dirname(__FILE__, 3) . '/storage/sessions');
ini_set('session.gc_probability', 1);
session_start();

// set up the application
$app = new \Lib\Framework\Core();

return $app;
