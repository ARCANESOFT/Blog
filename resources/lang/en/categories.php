<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'name' => 'Name',
        'slug' => 'Slug',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'categories'       => 'Categories',
        'categories-list'  => 'List of categories',
        'create-category'  => 'Create a category',
        'new-category'     => 'New Category',
        'edit-category'    => 'Edit a Category',
        'update-category'  => 'Update a Category',
        'category-details' => 'Category details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'      => 'The list of categories is empty !',
    'select-category' => '-- Select a category --',
    'has-no-posts'    => 'This category has no posts !',

    'messages'        => [
        'created' => [
            'title'   => 'Category created !',
            'message' => 'The category [:name] was created successfully !',
        ],

        'updated' => [
            'title'   => 'Category updated !',
            'message' => 'The category [:name] was updated successfully !',
        ],

        'deleted' => [
            'title'   => 'Category deleted !',
            'message' => 'The category [:name] has been successfully deleted !',
        ],

        'restored' => [
            'title'   => 'Category restored !',
            'message' => 'The category [:name] has been successfully restored !',
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

];
