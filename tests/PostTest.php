<?php

use PHPBlogdown\Blog;
use PHPBlogdown\PostCollection;

/**
 * Class PostTest
 */
class PostTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Blog
     */
    public function test_load()
    {
        return new Blog(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
    }

    /**
     * Check all the posts are loaded
     * @param Blog $blog
     * @depends test_load
     * @expectedException RuntimeException
     */
    public function test_get_posts_invalid_category(Blog $blog)
    {
        $posts = $blog->get_posts(new \PHPBlogdown\Category());
        $this->assertCount(0, $posts);
    }

    /**
     * Check all the posts are loaded
     * @param Blog $blog
     * @depends test_load
     * @return PostCollection
     */
    public function test_get_posts(Blog $blog)
    {
        $category = $blog->get_categories()->get('category');
        $this->assertInstanceOf('PHPBlogdown\Category', $category);

        $posts = $blog->get_posts($category);
        $this->assertInstanceOf('PHPBlogdown\PostCollection', $posts);

        $this->assertCount(1, $posts);

        return $posts;
    }

    /**
     * Get a post
     * @param PostCollection $posts
     * @depends test_get_posts
     */
    public function test_get_posts_get(PostCollection $posts)
    {
        $post = $posts->get('example_post');

        $this->assertNotEmpty($post);
        $this->assertEquals($post->title, 'Example Post');
    }

    /**
     * Attempt to get a post that does not exist
     * @param PostCollection $posts
     * @depends test_get_posts
     * @expectedException Exception
     */
    public function test_get_posts_get_invalid(PostCollection $posts)
    {
        $post = $posts->get('does_not_exist');
    }
}