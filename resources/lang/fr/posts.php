<?php

use Arcanesoft\Blog\Models\Post;

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'author'       => 'Auteur',
        'locale'       => 'Langue',
        'title'        => 'Titre',
        'slug'         => 'Slug',
        'permalink'    => 'Permalien',
        'excerpt'      => 'Extrait',
        'thumbnail'    => 'Vignette',
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
            'title'   => 'Supprimer la publication',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> cette publication: <strong>:title</strong> ?',
        ],

        'restore' => [
            'title'   => 'Restaurer la publication',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-primary">restaurer</span> cette publication: <strong>:title</strong> ?',
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
