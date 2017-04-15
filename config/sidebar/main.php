<?php

use Arcanesoft\Auth\Models\Role;

return [
    'title'       => 'blog::sidebar.blog',
    'name'        => 'blog',
    'icon'        => 'fa fa-fw fa-newspaper-o',
    'roles'       => [Role::ADMINISTRATOR],
    'permissions' => [],
    'children'    => [
        [
            'title'       => 'blog::sidebar.statistics',
            'name'        => 'blog-dashboard',
            'route'       => 'admin::blog.dashboard',
            'icon'        => 'fa fa-fw fa-bar-chart',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                \Arcanesoft\Blog\Policies\DashboardPolicy::PERMISSION_STATS,
            ],
        ],
        [
            'title'       => 'blog::sidebar.posts',
            'name'        => 'blog-posts',
            'route'       => 'admin::blog.posts.index',
            'icon'        => 'fa fa-fw fa-files-o',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                \Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_LIST,
            ],
        ],
        [
            'title'       => 'blog::sidebar.categories',
            'name'        => 'blog-categories',
            'route'       => 'admin::blog.categories.index',
            'icon'        => 'fa fa-fw fa-bookmark-o',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                \Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_LIST,
            ],
        ],
        [
            'title'       => 'blog::sidebar.tags',
            'name'        => 'blog-tags',
            'route'       => 'admin::blog.tags.index',
            'icon'        => 'fa fa-fw fa-tags',
            'roles'       => [Role::ADMINISTRATOR],
            'permissions' => [
                \Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_LIST,
            ],
        ],
    ],
];
