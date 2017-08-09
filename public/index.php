<?PHP

/**
 *  ChassisPHP - A PHP framework designed for CMS
 *
 * @package ChassisPHP
 * @copyright Copyright (c) 2017 Roger Creasy
 * @author  Roger Creasy <roger@chassisPHP.com>
 * @license https://github.com/RogerCreasy/ChassisPHP/blob/master/LICENSE
 */

//do the autoloading stuff
$app = require __DIR__.'/../lib/Framework/startApp.php';

    $response = $app->run();
    
    echo $response;
