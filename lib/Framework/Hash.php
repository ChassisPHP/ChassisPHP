<?php

namespace lib\Framework;

class Hash
{
    /**
     * Creates a hash of a string.
     *
     * @param  string  $string
     * @return string
     */
    public static function make(string $string)
    {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    /**
     * Check if a string matches a hash.
     *
     * @param  string  $string
     * @param  string  $hash
     * @return boolean
     */
    public static function check(string $string, string $hash)
    {
        return password_verify($string, $hash);
    }
}
