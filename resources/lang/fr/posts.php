<?php

use Arcanesoft\Blog\Models\Post;

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'title'        => 'Titre',
        'slug'         => 'Slug',
        'excerpt'      => 'Extrait',
        'content'      => 'Contenu',
        'category'     => 'Catégorie',
        'tags'         => 'Étiquettes',
        'status'       => 'Status',
        'published_at' => 'Date publication',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'posts'        => 'Publications',
        'posts-list'   => 'Liste des publications',
        'create-post'  => 'Créer une publication',
        'new-post'     => 'Nouvelle publication',
        'edit-post'    => 'Modifier une publication',
        'update-post'  => 'Mettre à jour une publication',
        'post-details' => 'Fiche publication',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty' => 'La liste des publications est vide !',

    'messages' => [
        'created' => [
            'title'   => 'Publication Créée !',
            'message' => 'La publication [:title] a été créée avec succès!',
        ],

        'updated' => [
            'title'   => 'Publication mise à jour !',
            'message' => 'La publication [:title] a été mise à jour avec succès !',
        ],

        'published' => [
            'title'   => 'Publication publiée !',
            'message' => 'La publication [:title] a été publié avec succès !',
        ],

        'unpublished' => [
            'title'   => 'Publication non publiée !',
            'message' => 'La publication [:title] a été mise en brouillon avec succès!',
        ],

        'deleted' => [
            'title'   => 'Publication supprimée !',
            'message' => 'La publication [:title] a été supprimée avec succès !',
        ],

        'restored' => [
            'title'   => 'Publication restaurée !',
            'message' => 'La publication [:title] a été restaurée avec succès !',
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
        POST::STATUS_DRAFT     => 'Brouillon',
        POST::STATUS_PUBLISHED => 'Publié',
    ],

];
