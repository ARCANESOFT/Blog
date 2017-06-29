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
        return new Collection([
            static::STATUS_DRAFT,
            static::STATUS_PUBLISHED,
        ]);
    }

    /**
     * Get all posts status
     *
     * @param  string|null  $locale
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all($locale = null)
    {
        return static::keys()->mapWithKeys(function ($key) use ($locale) {
            return [$key => trans("blog::posts.statuses.{$key}", [], $locale)];
        });
    }

    /**
     * Get a post status.
     *
     * @param  string       $key
     * @param  mixed        $default
     * @param  string|null  $locale
     *
     * @return string|null
     */
    public static function get($key, $default = null, $locale = null)
    {
        return self::all($locale)->get($key, $default);
    }
}
