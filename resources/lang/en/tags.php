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
        'tags'        => 'Tags',
        'tags-list'   => 'List of tags',
        'create-tag'  => 'Create a tag',
        'new-tag'     => 'New Tag',
        'edit-tag'    => 'Edit a Tag',
        'update-tag'  => 'Update a Tag',
        'tag-details' => 'Tag details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'The list of tags is empty !',
    'select-tag'   => '-- Select a tag --',
    'has-no-posts' => 'This tag has no posts !',

    'messages'   => [
        'created' => [
            'title'   => 'Tag Created !',
            'message' => 'The tag [:name] was created successfully !',
        ],

        'updated' => [
            'title'   => 'Tag Updated !',
            'message' => 'The tag [:name] was updated successfully !',
        ],

        'restored' => [
            'title'   => 'Tag Restored !',
            'message' => 'The tag [:name] has been successfully restored !',
        ],

        'deleted' => [
            'title'   => 'Tag Deleted !',
            'message' => 'The tag [:name] has been successfully deleted !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'restore' => [
            'title'   => 'Restore Tag',
            'message' => 'Are you sure you want to <span class="label label-primary">restore</span> this tag : <strong>:name</strong> ?',
        ],

        'delete' => [
            'title'   => 'Delete Tag',
            'message' => 'Are you sure you want to <span class="label label-danger">delete</span> this tag : <strong>:name</strong> ?',
        ],
    ],

];
