<?php namespace Arcanesoft\Blog\Listeners\Posts;

use Arcanesoft\Blog\Events\Posts\PostDeleting;

/**
 * Class     DeleteSeoData
 *
 * @package  Arcanesoft\Blog\Listeners\Posts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DeleteSeoData
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the event.
     *
     * @param  \Arcanesoft\Blog\Events\Posts\PostDeleting  $event
     */
    public function handle(PostDeleting $event)
    {
        if ($event->post->isForceDeleting()) {
            $event->post->deleteSeo();
        }
    }
}
