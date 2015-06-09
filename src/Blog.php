<?php
namespace PHPBlogdown;

/**
 * Class Blog
 * A very basic Markdown blog
 */
class Blog
{
    /**
     * @var Config
     */
    private $config;
    
    /**
     * @var Categories
     */
    public $categories;
    
    /**
     * @var Posts
     */
    public $posts;

    /**
     * Initialise a new Blog
     * @param string $file The path to the config.ini file
     */
    public function __construct($file)
    {
        $this->config = new Config($file);
        $this->categories = new Categories($this->config);
        $this->posts = new Posts($this->config);
    }

    /**
     * Returns the name of the blog
     * @return string
     */
    public function get_name()
    {
        return $this->config->get('blog.name');
    }
}