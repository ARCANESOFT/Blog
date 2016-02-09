<?php namespace Arcanesoft\Blog\Entities;

/**
 * Class     PostStatus
 *
 * @package  Arcanesoft\Blog\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostStatus
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const STATUS_DRAFT     = 'draft';
    const STATUS_PUBLISHED = 'published';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all posts status keys.
     *
     * @return array
     */
    public static function keys()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
        ];
    }

    /**
     * Get all posts status
     *
     * @return array
     */
    public static function all()
    {
        return array_map(function ($status) {
            return trans("blog::posts.statuses.$status");
        }, array_combine(self::keys(), self::keys()));
    }

    /**
     * Get a post status.
     *
     * @param  string  $key
     *
     * @return null|string
     */
    public static function get($key)
    {
        return array_get(self::all(), $key);
    }
}
