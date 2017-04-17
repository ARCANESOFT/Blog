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
        'categories'       => 'Catégories',
        'categories-list'  => 'Liste des catégories',
        'create-category'  => 'Créer une catégorie',
        'new-category'     => 'Nouvelle catégorie',
        'edit-category'    => 'Modifier une catégorie',
        'update-category'  => 'Mettre à jour une catégorie',
        'category-details' => 'Détails de la catégorie',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'      => 'La liste des catégories est vide.',
    'select-category' => '-- Sélectionner une catégorie --',
    'has-no-posts'    => "Cette catégorie n'a aucune de publications !",

    'messages'        => [
        'created' => [
            'title'   => 'Catégorie créée !',
            'message' => 'La catégorie [:name] a été créée avec succès !',
        ],

        'updated' => [
            'title'   => 'Category modifiée !',
            'message' => 'La catégorie [:name] a été modifiée avec succès !',
        ],

        'deleted' => [
            'title'   => 'Category supprimée !',
            'message' => 'La catégorie [:name] a été supprimée avec succès !',
        ],

        'restored' => [
            'title'   => 'Category restaurée !',
            'message' => 'La catégorie [:name] a été restaurée avec succès !',
        ],
    ],

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
