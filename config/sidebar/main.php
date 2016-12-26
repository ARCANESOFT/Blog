<?php

use Arcanesoft\Auth\Models\Role;

return [
    'title'       => 'Blog',
    'name'        => 'blog',
    'icon'        => 'fa fa-fw fa-newspaper-o',
    'roles'       => [Role::ADMINISTRATOR],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'Statistics',
            'name'        => 'blog-dashboard',
            'route'       => 'admin::blog.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['blog.dashboard.stats'],
        ],[
            'title'       => 'Posts',
            'name'        => 'blog-posts',
            'route'       => 'admin::blog.posts.index',
            'icon'        => 'fa fa-fw fa-files-o',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['blog.posts.list'],
        ],[
            'title'       => 'Categories',
            'name'        => 'blog-categories',
            'route'       => 'admin::blog.categories.index',
            'icon'        => 'fa fa-fw fa-bookmark-o',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['blog.categories.list'],
        ],[
            'title'       => 'Tags',
            'name'        => 'blog-tags',
            'route'       => 'admin::blog.tags.index',
            'icon'        => 'fa fa-fw fa-tags',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => ['blog.tags.list'],
        ]
    ],
];
