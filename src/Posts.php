<?php

namespace PHPBlogdown;

use PHPBlogdown\Interfaces\IConfig;
use PHPBlogdown\Interfaces\IPosts;
use \Michelf\Markdown;

/**
 * Class Posts
 * @package PHPBlogdown;
 * Handles everything to do
 * with the Blogs posts
 */
class Posts implements IPosts
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
     * Get a post
     * @param string $category
     * @param string $post
     * @return array
     */
    public function get($category, $post)
    {
        $ext = $this->config->get('blog.file_extension');
        $path = rtrim($this->config->get('blog.files_path'), '/');
        $file = $path.DIRECTORY_SEPARATOR.$category.DIRECTORY_SEPARATOR.$post.'.'.$ext;
        
        if (!$this->valid_filename($category) ||
            !$this->valid_filename($post) ||
            !file_exists($file))
            throw new \Exception('Invalid category or post name.');
            
        $file_contents = file_get_contents($file);
        
        $post = $this->read_post($file);
        $meta = $this->read_meta($file, $file_contents);
        
        $post = array_merge($post, $meta);
        $post['body'] = Markdown::defaultTransform($file_contents);
        
        return $post;
    }
    
    /**
     * Get all of the available posts
     * @param string $category
     * @return array
     */
    public function get_all($category)
    {
        if (!$this->valid_filename($category))
            throw new \Exception('Invalid filename');
        
        $path = rtrim($this->config->get('blog.files_path'), '/');
        $files = array_filter(glob($path.DIRECTORY_SEPARATOR.$category.DIRECTORY_SEPARATOR.'*'), 'is_file');
        
        $posts = $this->load_posts(
            $files,
            $this->config->get('blog.sort_key'),
            $this->config->get('blog.file_extension')
        );
        
        krsort($posts);
        
        return $posts;
    }
    
    /**
     * Loads a list of posts
     * 
     * @param array $files
     * @param string $key
     * @param string $ext
     */
    private function load_posts($files, $key = 'id', $ext = 'md')
    {
        $posts = [];
        
        foreach ($files AS $file)
        {
            if (pathinfo($file, PATHINFO_EXTENSION) !== $ext)
                continue;
            
            $post = $this->read_post($file);
            $meta = $this->read_meta($file, file_get_contents($file));
            $post = array_merge($post, $meta);
            
            $posts[$post[$key]] = $post;
        }
        
        return $posts;
    }
    
    /**
     * Read the metadata contained in the markdown file.
     * At the top of the file is an HTML comment 
     * that contains key = value pairs. This is
     * treated like an INI file and can have any
     * values needed.
     * @param string $file The file path
     * @param string $file_contents The contents of the file
     * @return array
     */
    private function read_meta($file, $file_contents)
    {
        preg_match("/<!--(.*?)-->/s", $file_contents, $matches);
        
        if (isset($matches[1]))
            return parse_ini_string($matches[1]);
        
        return [];
    }
    
    /**
     * Returns a formatted title
     * @param string $file
     */
    private function read_post($file)
    {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        
        return [
            'id' => $filename,
            'title' => $this->style($filename)
        ];
    }
    
    /**
     * Convert the post name
     * into a nicer format
     * @param string $name
     */
    private function style($name)
    {
        return ucwords(str_replace('_', ' ', $name));
    }
    
    /**
     * Ensure the filename is a
     * valid name and does not contain
     * special characters. Such as '../'.
     * @param string $name
     */
    private function valid_filename($name)
    {
        return preg_match("/^[a-z0-9-_\/]+$/", $name);
    }
}