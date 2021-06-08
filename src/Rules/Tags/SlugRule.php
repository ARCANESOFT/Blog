<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Rules\Tags;

use Arcanesoft\Blog\Blog;
use Illuminate\Validation\Rules\Unique;

/**
 * Class     SlugRule
 *
 * @package  Arcanesoft\Blog\Rules\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SlugRule
{

    public static function unique()
    {
        return new Unique(Blog::table('tags'), 'slug');
    }
}
