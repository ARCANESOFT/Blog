<?php

use Arcanesoft\Blog\Models\Post;

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'title'        => 'Title',
        'slug'         => 'Slug',
        'excerpt'      => 'Excerpt',
        'content'      => 'Content',
        'category'     => 'Category',
        'tags'         => 'Tags',
        'status'       => 'Status',
        'published_at' => 'Published at',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'posts'        => 'Posts',
        'posts-list'   => 'List of posts',
        'create-post'  => 'Create a post',
        'new-post'     => 'New Post',
        'edit-post'    => 'Edit a post',
        'update-post'  => 'Update a post',
        'post-details' => 'Post details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty' => 'The list of posts is empty !',

    'messages' => [
        'created' => [
            'title'   => 'Post Created !',
            'message' => 'The post [:title] was created successfully !',
        ],

        'updated' => [
            'title'   => 'Post Updated !',
            'message' => 'The post [:title] was updated successfully !',
        ],

        'published' => [
            'title'   => 'Post Published !',
            'message' => 'The post [:title] was published successfully !',
        ],

        'unpublished' => [
            'title'   => 'Post Unpublished !',
            'message' => 'The post [:title] was unpublished successfully !',
        ],

        'deleted' => [
            'title'   => 'Post Deleted !',
            'message' => 'The post [:title] was delete successfully !',
        ],

        'restored' => [
            'title'   => 'Post restored !',
            'message' => 'The post [:title] was restored successfully !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'delete' => [
            'title' => 'Delete Category',
            'message' => 'Are you sure you want to <span class="label label-danger">delete</span> this category: <strong>:name</strong> ?',
        ],

        'restore' => [
            'title'   => 'Restore Category',
            'message' => 'Are you sure you want to <span class="label label-primary">restore</span> this category: <strong>:name</strong> ?',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Statuses
     | -----------------------------------------------------------------
     */

    'statuses' => [
        POST::STATUS_DRAFT     => 'Draft',
        POST::STATUS_PUBLISHED => 'Published',
    ],

];
