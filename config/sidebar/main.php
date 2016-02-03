<?php

return [
    'title'       => 'Blog',
    'name'        => 'blog',
    'icon'        => 'fa fa-fw fa-newspaper-o',
    'roles'       => [],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'Statistics',
            'name'        => 'blog-dashboard',
            'route'       => 'blog::foundation.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [],
            'permissions' => ['blog.dashboard.stats'],
        ],[
            'title'       => 'Posts',
            'name'        => 'blog-posts',
            'route'       => 'blog::foundation.posts.index',
            'icon'        => 'fa fa-fw fa-files-o',
            'roles'       => [],
            'permissions' => ['blog.posts.list'],
        ],[
            'title'       => 'Categories',
            'name'        => 'blog-categories',
            'route'       => 'blog::foundation.categories.index',
            'icon'        => 'fa fa-fw fa-tags',
            'roles'       => [],
            'permissions' => ['blog.categories.list'],
        ],[
            'title'       => 'Tags',
            'name'        => 'blog-tags',
            'route'       => 'blog::foundation.tags.index',
            'icon'        => 'fa fa-fw fa-tags',
            'roles'       => [],
            'permissions' => ['blog.tags.list'],
        ]
    ],
];
