<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'name' => 'Nom',
        'slug' => 'Slug',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'categories' => 'Catégories'
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'      => 'La liste des catégories est vide.',
    'select-category' => '-- Sélectionner une catégorie --',

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'delete' => [
            'title'   => 'Supprimer une catégorie',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> cette catégorie: <strong>:name</strong> ?',
        ],

        'restore' => [
            'title'   => 'Restaurer une catégorie',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-primary">restaurer</span> cette catégorie: <strong>:name</strong> ?',
        ],
    ],

];
