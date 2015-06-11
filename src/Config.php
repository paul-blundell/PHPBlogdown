<?php

namespace PHPBlogdown;

use PHPBlogdown\Interfaces\IConfig;

class Config implements IConfig
{
    /**
     * @var array
     */
    private $config;
    
    /**
     * Initialise the config
     * @param string $file
     */
    public function __construct($file)
    {
        if (!file_exists($file))
            throw new \Exception('Invalid config file.');
            
        $this->config = parse_ini_file($file);
        
        if (!$this->config)
            throw new \Exception('Unable to parse config file.');
    }
    
    /**
     * Get a config value
     * @param string $name
     */
    public function get($name)
    {
        if (!isset($this->config[$name]))
            throw new \Exception('Configuration key does not exist.');
        
        return $this->config[$name];    
    }
}