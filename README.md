# PHPBlogdown

A simple and fast blogging platform for markdown documents.

## What is this

This is the core of PHPBlogdown, this is where the magic happens. You can use the core like the following:

    $blog = new PHPBlogdown\Blog('config.ini');
    $categories = $blog->categories->get_all();
    
or to get a post:

    $blog = new PHPBlogdown\Blog('config.ini');
    $post = $blog->posts->get('about', 'what_is_this');

which will return an array like so:
    
    [
        'id' => 'what_is_this',
        'title' => 'What Is This',
        'summary' => 'PHP Blogdown is..<ommitted>',
        'author' => 'Paul Blundell',
        'date' => '2015-06-11 12:00',
        'body' => '<html_output>'
    ]
   
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

## Installation

Coming soon.

