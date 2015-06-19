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
     * @var CategoryCollection
     */
    private $categories;

    /**
     * Initialise a new Blog
     * @param string $file The path to the config.ini file
     */
    public function __construct($file)
    {
        $this->config = new Config($file);
    }

    /**
     * Returns the name of the blog
     * @return string
     */
    public function get_name()
    {
        return $this->config->get('blog.name');
    }

    /**
     * Returns the categories
     * @return CategoryCollection
     */
    public function get_categories()
    {
        if (!is_null($this->categories))
            return $this->categories;

        return $this->categories = new CategoryCollection(
            $this->config->get('blog.files_path')
        );
    }

    /**
     * Returns the posts in the specified category
     * @param Category $category
     * @return PostCollection
     */
    public function get_posts(Category $category)
    {
        $collection = new PostCollection();

        $ext = $this->config->get('blog.file_extension') ?: 'md';

        $dir = new \DirectoryIterator($category->path);
        foreach ($dir AS $file)
        {
            if ($file->isDir() || $file->isDot() || $file->getExtension() !== $ext)
                continue;

            $collection->add($this->new_post(
                $file->getBasename('.'.$ext),
                $file->getPathname()
            ));
        }

        $collection->sort($this->config->get('blog.sort_key'), PostCollection::SORT_DESC);

        return $collection;
    }

    /**
     * Returns an individual post in the
     * specified category
     * @param Category $category
     * @param string $post_id
     * @return Post
     */
    public function get_post(Category $category, $post_id)
    {
        $ext = $this->config->get('blog.file_extension') ?: 'md';
        $file = $category->path.DIRECTORY_SEPARATOR.$post_id.'.'.$ext;

        return $this->new_post($post_id, $file);
    }

    /**
     * Creates a new Post object
     * @param $id
     * @param $path
     * @return Post
     */
    private function new_post($id, $path)
    {
        $post = new Post();
        $post->id = $id;
        $post->title = ucwords(str_replace('_', ' ', $id));
        $post->path = $path;

        $this->parse_meta($post);

        return $post;
    }

    /**
     * Read the metadata contained in the markdown file.
     * At the top of the file is an HTML comment
     * that contains key = value pairs. This is
     * treated like an INI file and can have any
     * values needed.
     * @param Post $post
     */
    private function parse_meta(Post &$post)
    {
        preg_match("/<!--(.*?)-->/s", file_get_contents($post->path), $matches);

        if (isset($matches[1]))
        {
            $meta = parse_ini_string($matches[1]);

            foreach ($meta AS $key=>$value)
                $post->$key = $value;
        }
    }
}