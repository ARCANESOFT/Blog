<?php

return [

    /* -----------------------------------------------------------------
     |  Route
     | -----------------------------------------------------------------
     */

    'route'    => [
        'prefix' => 'blog',
    ],

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database' => [
        'connection' => config('database.default'),

        'prefix'     => 'blog_',
    ],

    /* -----------------------------------------------------------------
     |  Models
     | -----------------------------------------------------------------
     */

    'posts' => [
        'table'    => 'posts',
        'model'    => \Arcanesoft\Blog\Models\Post::class,
        'observer' => \Arcanesoft\Blog\Models\Observers\PostObserver::class,
    ],

    'categories' => [
        'table'    => 'categories',
        'model'    => \Arcanesoft\Blog\Models\Category::class,
        'observer' => \Arcanesoft\Blog\Models\Observers\CategoryObserver::class,
    ],

    'tags' => [
        'table'    => 'tags',
        'model'    => \Arcanesoft\Blog\Models\Tag::class,
        'observer' => \Arcanesoft\Blog\Models\Observers\TagObserver::class,
    ],

    /* -----------------------------------------------------------------
     |  Translatable
     | -----------------------------------------------------------------
     */

    'translatable' => [
        'enabled' => false,
    ],

];
