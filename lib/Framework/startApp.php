<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */

//set a constant with the time we are starting
define('CHASSIS_START', microtime(true));

//crank up the Composer autoloading
require __DIR__.'/../../vendor/autoload.php';

//set up the application
$app = new \Lib\Framework\Core();

return $app;
