<?php

namespace Lib\Framework;

class Session
{
    public static $sessionStarted = false;

    // no real advantage to do this here. added for consistency
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        } else {
            // TODO add exception
        }
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

    // clear an individual session key
    public static function clear($key)
    {
        unset($_SESSION[$key]);
    }

    // message handling
    // set message
    public static function setMessage($type, $message)
    {
        $_SESSION['message']['type'] = $type;
        $_SESSION['message']['content'] = $message;
    }

    // message handling
    // get message
    public static function getMessage($unset = true)
    {
        if (isset($_SESSION['message']['content'])) {
            $message = array(
                'type' => $_SESSION['message']['type'],
                'content' => $_SESSION['message']['content'],
            );
            if ($unset) {
                unset($_SESSION['message']['type']);
                unset($_SESSION['message']['content']);
            }
            return $message;
        } else {
            return false;
        }
    }

    // destroy the session when we are done with it
    public static function destroy()
    {
            session_unset();
            session_destroy();
    }
}
