<?php

namespace PHPBlogdown;

class Category
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $path;

    /**
     * @var CategoryCollection
     */
    public $children;
}