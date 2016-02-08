<?php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Database
     | ------------------------------------------------------------------------------------------------
     */
    'database' => [
        'connection' => config('database.default'),
        'prefix'     => 'blog_',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Route
     | ------------------------------------------------------------------------------------------------
     */
    'route'    => [
        'prefix'    => 'blog',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Models
     | ------------------------------------------------------------------------------------------------
     */
    'posts' => [
        'table'    => 'posts',
        'model'    => Arcanesoft\Blog\Models\Post::class,
        'observer' => Arcanesoft\Blog\Observers\PostObserver::class,
    ],

    'categories' => [
        'table'    => 'categories',
        'model'    => Arcanesoft\Blog\Models\Category::class,
        'observer' => Arcanesoft\Blog\Observers\CategoryObserver::class,
    ],

    'tags' => [
        'table'    => 'tags',
        'model'    => Arcanesoft\Blog\Models\Tag::class,
        'observer' => Arcanesoft\Blog\Observers\TagObserver::class,
    ],
];
