<?php

return [

    /* -----------------------------------------------------------------
     |  Connections
     | -----------------------------------------------------------------
     */

    'connection' => env('DB_CONNECTION', 'mysql'),

    /* -----------------------------------------------------------------
     |  Tables
     | -----------------------------------------------------------------
     */

    'prefix'     => 'blog_',

    'tables' => [
        'authors'  => 'authors',
        'pages'    => 'pages',
        'posts'    => 'posts',
        'tags'     => 'tags',
        'post_tag' => 'post_tag',
    ],

    /* -----------------------------------------------------------------
     |  Models
     | -----------------------------------------------------------------
     */

    'models' => [
        'author' => Arcanesoft\Blog\Models\Author::class,
        'page'   => Arcanesoft\Blog\Models\Page::class,
        'post'   => Arcanesoft\Blog\Models\Post::class,
        'tag'    => Arcanesoft\Blog\Models\Tag::class,
    ],

];
