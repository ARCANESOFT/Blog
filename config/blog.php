<?php

use Arcanesoft\Blog\Events;
use Arcanesoft\Blog\Listeners;

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
        'table' => 'posts',
        'model' => Arcanesoft\Blog\Models\Post::class,
    ],

    'categories' => [
        'table' => 'categories',
        'model' => Arcanesoft\Blog\Models\Category::class,
    ],

    'tags' => [
        'table' => 'tags',
        'model' => Arcanesoft\Blog\Models\Tag::class,
    ],

    /* -----------------------------------------------------------------
     |  Translatable
     | -----------------------------------------------------------------
     */

    'translatable' => [
        'enabled' => false,
    ],

    /* -----------------------------------------------------------------
     |  Seoable
     | -----------------------------------------------------------------
     */

    'seoable' => [
        'enabled' => false,
    ],

    /* -----------------------------------------------------------------
     |  Cache
     | -----------------------------------------------------------------
     */

    'cache' => [
        'categories' => [
            'select-data' => 5,
        ],
    ],

    /* -----------------------------------------------------------------
     |  Events
     | -----------------------------------------------------------------
     */

    'events' => [

        'listeners' => [

            // Posts
            //-----------------------------------------------------

            Events\Posts\PostCreating::class  => [],
            Events\Posts\PostCreated::class   => [],
            Events\Posts\PostUpdating::class  => [],
            Events\Posts\PostUpdated::class   => [],
            Events\Posts\PostSaving::class    => [],
            Events\Posts\PostSaved::class     => [],
            Events\Posts\PostDeleting::class  => [
                Listeners\Posts\DeleteSeoData::class,
            ],
            Events\Posts\PostDeleted::class   => [],
            Events\Posts\PostRestoring::class => [],
            Events\Posts\PostRestored::class  => [],

            // Categories
            //-----------------------------------------------------

            Events\Categories\CategoryCreating::class  => [],
            Events\Categories\CategoryCreated::class   => [
                Listeners\Categories\ClearCategoriesSelectDataCache::class,
            ],
            Events\Categories\CategoryUpdating::class  => [],
            Events\Categories\CategoryUpdated::class   => [],
            Events\Categories\CategorySaving::class    => [],
            Events\Categories\CategorySaved::class     => [],
            Events\Categories\CategoryDeleting::class  => [],
            Events\Categories\CategoryDeleted::class   => [
                Listeners\Categories\ClearCategoriesSelectDataCache::class,
            ],
            Events\Categories\CategoryRestoring::class => [],
            Events\Categories\CategoryRestored::class  => [],

            // Tags
            //-----------------------------------------------------

            Events\Tags\TagCreating::class  => [],
            Events\Tags\TagCreated::class   => [
                Listeners\Tags\ClearTagsSelectDataCache::class,
            ],
            Events\Tags\TagUpdating::class  => [],
            Events\Tags\TagUpdated::class   => [],
            Events\Tags\TagSaving::class    => [],
            Events\Tags\TagSaved::class     => [],
            Events\Tags\TagDeleting::class  => [],
            Events\Tags\TagDeleted::class   => [
                Listeners\Tags\ClearTagsSelectDataCache::class,
            ],
            Events\Tags\TagRestoring::class => [],
            Events\Tags\TagRestored::class  => [],
        ],

    ],

];
