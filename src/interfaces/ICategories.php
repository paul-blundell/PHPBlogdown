<?php

namespace PHPBlogdown\Interfaces;

interface ICategories
{
    /**
     * Get a list of subcategories
     * @param string $parent
     * @return array
     */
    public function get($parent);
    
    /**
     * Get all of the available categories
     * @return array
     */
    public function get_all();
}