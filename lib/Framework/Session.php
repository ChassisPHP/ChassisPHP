<?PHP

namespace Lib\Framework;

class Session
{
    // no real advantage to do this here. added for consistency
    public static function start()
    {
        session_start();
    }

    // set a session key value
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // get a session key value, handle non-existent key
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }
}
