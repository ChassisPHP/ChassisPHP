<?PHP

namespace Lib\Framework;

use ArrayAccess;

class Config implements ArrayAccess
{
    private $config = array();
    
    public function __construct()
    {
        // Read the config files
        $configDir =  dirname(__FILE__, 3) . "/Config/*.php";

        foreach (glob($configDir) as $configFile) {
            $configs = include($configFile);
        
            foreach ($configs as $config) {
                $this->config = $config;
            }
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
         return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }
}
