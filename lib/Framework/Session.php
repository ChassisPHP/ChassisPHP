<?php

namespace Lib\Framework;

class Session
{
    private $session = false;

    // no real advantage to do this here. added for consistency
    public static function start()
    {
        session_start();
        self::session == true;
    }

    // set a session key value
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // get a session key value, handle non-existent key
    public static function get($key, $childKey = null)
    {
        if ($childKey) {
            if (isset($_SESSION[$key][$childKey])) {
                return $_SESSION[$key][$childKey];
            }
        } else {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
            return false;
    }

    // destroy the session when we are done with it
    public static function destroy()
    {
        if (self::session) {
            session_unset();
            session_destroy();
        }
    }
}
