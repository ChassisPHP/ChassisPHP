<?PHP

/**
 * Author: Roger Creasy
 * Email:  roger@rogercreasy.com
 * Date:   Saturday, July 15, 2017 05:47
 */


// set the timeout for the session
$timeout = 1800;

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
