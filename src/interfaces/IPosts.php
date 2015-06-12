<?php

namespace PHPBlogdown\Interfaces;

interface IPosts
{
    /**
     * Get a post by ID
     * @param string $category
     * @param string $post
     * @return array
     */
    public function get($category, $post);
    
    /**
     * Get all of the available posts
     * @param string $category
     * @return array
     */
    public function get_all($category);
}