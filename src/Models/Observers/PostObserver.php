<?php namespace Arcanesoft\Blog\Models\Observers;

use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostObserver
 *
 * @package  Arcanesoft\Blog\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Replace Observers by Events/Listeners
 */
class PostObserver extends AbstractObserver
{
    /**
     * Listen to the Post deleted event.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     */
    public function deleting(Post $post)
    {
        if ($post->isForceDeleting()) {
            $post->deleteSeo();
        }
    }
}
