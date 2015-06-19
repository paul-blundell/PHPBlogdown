# PHPBlogdown

A simple and fast blogging platform for markdown documents.

## What is this

This is the core of PHPBlogdown, this is where the magic happens.

### Getting Started

You can use PHPBlogdown like the following:

    $blog = new PHPBlogdown\Blog('config.ini');
    $categories = $blog->get_categories();

#### Categories

`$categories` can now be iterated like the following, which will process all categories including sub-categories:

    foreach (new RecursiveIteratorIterator($categories, RecursiveIteratorIterator::SELF_FIRST) AS $node)
    {
        echo $node->name;
    }

Or you can get a specific category:

    $category = $categories->get('category');

Or for a sub-category:

    $subcategory = $categories->get('category')->children->get('sub');
    
#### Posts

This will get a list of posts in the category:

    $category = $categories->get('my-category');
    $posts = $blog->get_posts($category);

The following will get a specific post:

    $category = $categories->get('my-category');
    $post = $blog->get_post($category, 'what_is_this');
    $title = $post->title;
    $custom = $post->my_custom_meta_parameter;

which will return a `Post` object with the following public parameters:
    
    id = The filename of the post without the extension
    title = The filename of the post with underscores replaced with spaces
    path = The full path to the file

You can also call any custom parameters you specified in the posts metadata, e.g. `$post->custom`.

To get the HTML output:

    $post->getBody();
    
#### Metadata    
   
The posts metadata, summary, autor, etc. is defined at the top of the markdown document, like so:

    <!--
    summary = "PHP Blogdown is a quick and easy blogging platform. Upload your markdown documents and everything is created for you..."
    author = Paul Blundell
    date = 2015-06-11 11:56
    -->

This must be the first HTML-style comment in the document. This is processed by PHP Blogdown as if it were an INI file, so you can add as much meta information as needed and it will be returned in the array.

## The config file

You must specify a path to a config file when initialising the Blog. The config file should look like the following:
	
	[blog]
	
	; The blogs name
	;
	blog.name = Test
	
	; The path to the Markdown files
	;
	blog.files_path = /the/path/to/the/posts/directory/
	
	; Number of posts to show per page
	; (Coming soon)
	blog.items_per_page = 10
	
	; The extension of the Markdown files
	;
	blog.file_extension = md

Then create a new folder somewhere which will be where you upload your markdown files. Sub-directories of this folder will be the Blogs categories. You must have at least 1 category.

## Why should I use this?

I don't know. If you think it suits your needs then go ahead and use it :)

## Installation

Download and run `composer install`.

Alternatively, you can download a ready made website that uses PHPBlogdown [here](https://github.com/paul-blundell/phpblogdown-app), built with Slim Framework and Twig.

