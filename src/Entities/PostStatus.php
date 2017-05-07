<?php namespace Arcanesoft\Blog\Entities;

use Arcanedev\Support\Collection;

/**
 * Class     PostStatus
 *
 * @package  Arcanesoft\Blog\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostStatus
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const STATUS_DRAFT     = 'draft';
    const STATUS_PUBLISHED = 'published';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get all posts status keys.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function keys()
    {
        return self::all()->keys();
    }

    /**
     * Get all posts status
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return new Collection(trans('blog::posts.statuses'));
    }

    /**
     * Get a post status.
     *
     * @param  string  $key
     *
     * @return string|null
     */
    public static function get($key)
    {
        return self::all()->get($key);
    }
}
