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
}
