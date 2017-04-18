<?php namespace Arcanesoft\Blog\Models\Presenters;

/**
 * Trait PostPresenter
 *
 * @package  Arcanesoft\Blog\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait PostPresenter
{
    // TODO: Add the accessors

    /* -----------------------------------------------------------------
     |  URL Accessors
     | -----------------------------------------------------------------
     */

    /**
     * Get the show URL.
     *
     * @return string
     */
    public function getShowUrl()
    {
        return route('admin::blog.posts.show', $this);
    }

    /**
     * Get the edit URL.
     *
     * @return string
     */
    public function getEditUrl()
    {
        return route('admin::blog.posts.edit', $this);
    }
}
