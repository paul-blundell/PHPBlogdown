<?php

namespace PHPBlogdown;

use \Michelf\Markdown;

class Post
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->meta[$key];
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->meta[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->meta);
    }

    /**
     * Parse the markdown and return the posts body
     * @return string
     */
    public function get_body()
    {
        return Markdown::defaultTransform(file_get_contents($this->path));
    }
}