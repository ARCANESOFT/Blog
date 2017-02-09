<?php namespace Arcanesoft\Blog\Models\Observers;

use Arcanesoft\Blog\Models\Tag;

/**
 * Class     TagObserver
 *
 * @package  Arcanesoft\Blog\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagObserver extends AbstractObserver
{
    /* ------------------------------------------------------------------------------------------------
     |  Events
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Listen to the Tag saved event.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     */
    public function saved(Tag $tag)
    {
        $tag->clearCache();
    }

    /**
     * Listen to the Tag deleted event.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     */
    public function deleted(Tag $tag)
    {
        $tag->clearCache();
    }
}
