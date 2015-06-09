<?php

namespace PHPBlogdown;

use PHPBlogdown\Interfaces\IConfig;
use PHPBlogdown\Interfaces\ICategories;

/**
 * Class Categories
 * @package PHPBlogdown
 * Handles everything to do with
 * the Categories.
 */
class Categories implements ICategories
{
    /**
     * @var IConfig
     */
    private $config;
    
    /**
     * @param IConfig $config
     */
    public function __construct(IConfig $config)
    {
        $this->config = $config;
    }
    
    /**
     * Get a list of subcategories
     * @param string $parent
     * @throws \Exception
     * @return array
     */
    public function get($parent)
    {
        if (!$this->valid_filename($parent))
            throw new \Exception('Invalid category name.');
        
        $path = rtrim($this->config->get('blog.files_path'), '/').DIRECTORY_SEPARATOR.$parent;
        
        return $this->parse_categories(new \DirectoryIterator($path));
    }
    
    /**
     * Get all of the available categories
     * @return array
     */
    public function get_all()
    {
        $path = rtrim($this->config->get('blog.files_path'), '/');
        
        return $this->parse_categories(new \DirectoryIterator($path));
    }
        
    /**
     * Recursive function to parse
     * the categories directory
     * @param \DirectoryIterator $dir
     * @return array
     */
    private function parse_categories(\DirectoryIterator $dir)
    {
        $data = [];
        foreach ($dir as $node)
        {
            if ($node->isDir() && !$node->isDot())
            {
                $data[$node->getFilename()] = [
                    'id' => $node->getFilename(),
                    'name' => $this->style($node->getFilename()),
                    'subcategories' => $this->parse_categories(new \DirectoryIterator($node->getPathname()))
                ];
            }
        }
        
        return $data;
    }
    
    /**
     * Convert the category name
     * into a nicer format
     * @param string $name
     */
    private function style($name)
    {
        return ucwords(str_replace('_', ' ', $name));
    }
    
    /**
     * Ensure the category name is a
     * valid name and does not contain
     * special characters. Such as '../'.
     * @param string $name
     */
    private function valid_filename($name)
    {
        return preg_match("/^[a-z0-9-_]+$/", $name);
    }
}