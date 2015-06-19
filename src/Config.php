<?php

namespace PHPBlogdown;

/**
 * Class Config
 * @package PHPBlogdown
 */
class Config
{
    /**
     * @var array
     */
    private $config;
    
    /**
     * Initialise the config
     * @param string $file
     * @throws \Exception
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
     * @return null|string
     */
    public function get($name)
    {
        if (!isset($this->config[$name]))
            return null;
        
        return $this->config[$name];    
    }
}