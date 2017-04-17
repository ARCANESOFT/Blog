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
        'tags'        => 'Étiquettes',
        'tags-list'   => 'Liste des étiquettes',
        'create-tag'  => 'Créer une étiquette',
        'new-tag'     => 'Nouvelle étiquette',
        'edit-tag'    => 'Modifier une étiquette',
        'update-tag'  => 'Mettre à jour une étiquette',
        'tag-details' => 'Détails de l\'étiquette',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'La liste des étiquettes est vide !',
    'select-tag'   => '-- Sélectionner une étiquette --',
    'has-no-posts' => "Cette étiquette n'a aucune publications !",

    'messages'   => [
        'created' => [
            'title'   => 'Étiquette créée !',
            'message' => "L'étiquette [:name] a été créée avec succès !",
        ],

        'updated' => [
            'title'   => 'Étiquette modifiée !',
            'message' => 'L\'étiquette [:name] a été modifiée avec succès !',
        ],

        'restored' => [
            'title'   => 'Étiquette restaurée !',
            'message' => 'L\'étiquette [:name] a été restaurée avec succès !',
        ],

        'deleted' => [
            'title'   => 'Étiquette supprimée !',
            'message' => 'L\'étiquette [:name] a été supprimée avec succès !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'restore' => [
            'title'   => 'Restaurer une étiquette',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-primary">restaurer</span> cette étiquette : <strong>:name</strong> ?',
        ],

        'delete' => [
            'title'   => 'Supprimer une étiquette',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> cette étiquette : <strong>:name</strong> ?',
        ],
    ],

];
