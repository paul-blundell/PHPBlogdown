<?php

use PHPBlogdown\Config;
use PHPBlogdown\CategoryCollection;

/**
 * Class CategoriesTest
 */
class CategoriesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return CategoryCollection
     */
    public function test_load()
    {
        $config = new Config(__DIR__.DIRECTORY_SEPARATOR.'config.ini');
        $this->assertNotNull($config->get('blog.files_path'));

        $categories = new CategoryCollection($config->get('blog.files_path'));
        $this->assertInstanceOf('PHPBlogdown\CategoryCollection', $categories);

        return $categories;
    }

    /**
     * Retrieve the list of categories and ensure
     * they are as expected
     * @param CategoryCollection $categories
     * @depends test_load
     */
    public function test_get_all(CategoryCollection $categories)
    {
        $this->assertNotEmpty($categories);
        $this->assertCount(2, $categories);
    }

    /**
     * Retrieve the list of subcategories for a
     * parent category
     * @param CategoryCollection $categories
     * @depends test_load
     */
    public function test_get(CategoryCollection $categories)
    {
        $category = $categories->get('category');
        $this->assertNotNull($category);
        $this->assertEquals($category->name, 'Category');
        $this->assertCount(1, $category->children);
    }
}