<?php

use \Arcanesoft\Blog\Entities\PostStatus;

return [
    'statuses' => [
        PostStatus::STATUS_DRAFT     => 'Brouillon',
        PostStatus::STATUS_PUBLISHED => 'Publié',
    ],
];
