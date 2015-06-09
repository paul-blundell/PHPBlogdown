<?php

namespace PHPBlogdown;

use PHPBlogdown\Interfaces\IConfig;

class Config implements IConfig
{
    private $config;
    
    public function __construct($file)
    {
        if (!file_exists($file))
            throw new \Exception('Invalid config file.');
            
        $this->config = parse_ini_file($file);
        
        if (!$this->config)
            throw new \Exception('Unable to parse config file.');
    }
    
    public function get($name)
    {
        if (!isset($this->config[$name]))
            throw new \Exception('Configuration key does not exist.');
        
        return $this->config[$name];    
    }
}