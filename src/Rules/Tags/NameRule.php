<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Rules\Tags;

use Arcanesoft\Blog\Blog;
use Illuminate\Validation\Rules\Unique;

/**
 * Class     NameRule
 *
 * @package  Arcanesoft\Blog\Rules\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class NameRule
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make a unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    public static function unique(): Unique
    {
        return new Unique(Blog::table('tags'), 'name');
    }
}
