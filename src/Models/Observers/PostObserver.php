<?php namespace Arcanesoft\Blog\Models\Observers;

use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostObserver
 *
 * @package  Arcanesoft\Blog\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostObserver extends AbstractObserver
{
    /**
     * Listen to the Category deleted event.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     */
    public function deleting(Post $post)
    {
        if ($post->isForceDeleting()) {
            //
        }
    }
}
