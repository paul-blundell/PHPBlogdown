<?php

namespace PHPBlogdown;

/**
 * Class PostCollection
 * @package PHPBlogdown
 */
class PostCollection implements \Iterator, \Countable
{
    /**
     * Sort Orders
     */
    const SORT_ASC = 1;
    const SORT_DESC = 2;

    /**
     * @var array
     */
    private $posts = [];

    /**
     * @param Post $post
     */
    public function add(Post $post)
    {
        $this->posts[$post->id] = $post;
    }

    /**
     * @param $post
     * @return Post
     * @throws \Exception
     */
    public function get($post)
    {
        if (!isset($this->posts[$post]))
            throw new \Exception('Invalid post identifier');

        return $this->posts[$post];
    }

    /**
     * @param string $key
     * @param int $order
     */
    public function sort($key = 'id', $order = self::SORT_ASC)
    {
        usort($this->posts, function($a, $b) use ($key, $order)
        {
            if ($order == self::SORT_DESC)
                return strcmp($b->$key, $a->$key);

            return strcmp($a->$key, $b->$key);
        });
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->posts);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->posts);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->posts);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->posts);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->posts);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->posts);

        return ($key !== NULL && $key !== FALSE);
    }
}