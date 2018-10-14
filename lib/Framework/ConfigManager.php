<?php

namespace Lib\Framework;

use ArrayAccess;

/**
 * Class Config
 * @package Lib\Framework
 */
class ConfigManager implements ArrayAccess
{
    /** @var static */
    protected static $instance;

    /** @var array */
    private $config = [];

    /**
     * @return ConfigManager
     */
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self;
        }

        return static::$instance;
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public static function get($property)
    {
        return static::instance()->getProperty($property);
    }

    /**
     * Config constructor.
     */
    protected function __construct()
    {
        // Read the config files
        $configDir = dirname(__FILE__, 3) . "/Config/*.php";

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

    /**
     * Takes in path in dot-notation and returns the appropriate value. (e.g. 'app.gcProb')
     *
     * @param $property
     * @return mixed|null
     */
    protected function getProperty($property)
    {
        $value = $this->config;
        $path = explode('.', $property);

        while (sizeof($path) > 0 && is_array($value)) {
            $nextKey = array_shift($path);
            if (!key_exists($nextKey, $value)) {
                return null;
            }
            $value = $value[$nextKey];
        }

        return $value;
    }
}
