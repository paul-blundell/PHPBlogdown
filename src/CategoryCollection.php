<?php

namespace PHPBlogdown;

/**
 * Class CategoryCollection
 * @package PHPBlogdown
 */
class CategoryCollection implements \RecursiveIterator, \Countable
{
    /**
     * @var array
     */
    private $categories = [];

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $node)
        {
            if (!$node->isDir() || $node->isDot())
                continue;

            $category = new Category();
            $category->id = $node->getFilename();
            $category->name = ucwords(str_replace('_', ' ', $node->getFilename()));
            $category->path = $node->getPathname();
            $category->children = new self($node->getPathname());

            $this->add($category);
        }
    }

    /**
     * Add a new Category
     * @param Category $category
     */
    public function add(Category $category)
    {
        $this->categories[$category->id] = $category;
    }

    /**
     * Get a specific category
     * Can either specify a top-level category
     * or any sub-level category.
     * e.g. another/sub/subsub
     * @param $category
     * @return Category
     * @throws \Exception
     */
    public function get($category)
    {
        if (!isset($this->categories[$category]))
            throw new \Exception('Invalid category identifier');

        return $this->categories[$category];
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->categories);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->categories);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->categories);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->categories);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->categories);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->categories);

        return ($key !== NULL && $key !== FALSE);
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        $key = key($this->categories);

        return count($this->categories[$key]->children) > 0;
    }

    /**
     * @return \RecursiveIterator
     */
    public function getChildren()
    {
        $key = key($this->categories);

        return $this->categories[$key]->children;
    }
}