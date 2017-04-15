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
        'categories' => 'Categories',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'      => 'The list of categories is empty.',
    'select-category' => '-- Select a category --',

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
