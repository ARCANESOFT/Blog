<?php namespace Arcanesoft\Blog\Listeners\Tags;

use Arcanesoft\Blog\Events\Tags\AbstractTagEvent;
use Arcanesoft\Blog\Models\Tag;

/**
 * Class     ClearTagsSelectDataCache
 *
 * @package  Arcanesoft\Blog\Listeners\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ClearTagsSelectDataCache
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the event.
     *
     * @param  \Arcanesoft\Blog\Events\Tags\AbstractTagEvent  $event
     */
    public function handle(AbstractTagEvent $event)
    {
        cache()->forget(Tag::SELECT_CACHE_NAME);
    }
}
