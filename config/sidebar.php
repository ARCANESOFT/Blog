<?php

return [

    /* -----------------------------------------------------------------
     |  Sidebar's items
     | -----------------------------------------------------------------
     */

    'items' => [
        [
            'name'        => 'blog::main',
            'title'       => 'Blog',
            'icon'        => 'fas fa-fw fa-blog',
            'roles'       => [],
            'permissions' => [],
            'children'    => [
                [
                    'name'        => 'blog::main.dashboard',
                    'title'       => 'Statistics',
                    'icon'        => 'fa fa-fw fa-tachometer-alt',
                    'route'       => 'admin::blog.index',
                    'roles'       => [
                        'blog-author',
                        'blog-moderator',
                    ],
                    'permissions' => [
                        'admin::blog.statistics.index',
                    ],
                ],
                [
                    'name'        => 'blog::main.posts',
                    'title'       => 'Posts',
                    'icon'        => 'far fa-fw fa-newspaper',
                    'route'       => 'admin::blog.posts.index',
                    'roles'       => [
                        'blog-author',
                        'blog-moderator',
                    ],
                    'permissions' => [
                        'admin::blog.posts.index',
                    ],
                ],
                [
                    'name'        => 'blog::main.tags',
                    'title'       => 'Tags',
                    'icon'        => 'fas fa-fw fa-tags',
                    'route'       => 'admin::blog.tags.index',
                    'roles'       => [
                        'blog-author',
                        'blog-moderator',
                    ],
                    'permissions' => [
                        'admin::blog.tags.index',
                    ],
                ],
                [
                    'name'        => 'blog::main.authors',
                    'title'       => 'Authors',
                    'icon'        => 'fas fa-fw fa-user-edit',
                    'route'       => 'admin::blog.authors.index',
                    'roles'       => [
                        'blog-moderator',
                    ],
                    'permissions' => [
                        'admin::blog.authors.index',
                    ],
                ],
            ],
        ],
    ],

];
