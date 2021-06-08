<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class     PostTag
 *
 * @package  Arcanesoft\Blog\Models\Pivots
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostTag extends Pivot
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'tag_id'  => 'integer',
    ];
}
