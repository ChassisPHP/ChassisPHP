<?php

namespace Lib\Framework;

use ArrayAccess;

/**
 * Class Config
 * @package Lib\Framework
 */
class Config implements ArrayAccess
{
    /** @var array  */
    private $config = [];

    /**
     * Config constructor.
     */
    public function __construct()
    {
        // Read the config files
        $configDir =  dirname(__FILE__, 3) . "/Config/*.php";

        foreach (glob($configDir) as $configFile) {
            $configs = include($configFile);

            $configName = pathinfo($configFile)['filename'];
            $this->config[$configName] = $configs;
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
         return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }
}
