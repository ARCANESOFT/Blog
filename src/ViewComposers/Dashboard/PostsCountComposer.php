<?php namespace Arcanesoft\Blog\ViewComposers\Dashboard;

use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     PostsCountComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsCountComposer extends AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::admin._composers.dashboard.posts-total-box';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $posts = $this->cachedPosts();

        $view->with('postsCount', $posts->count());
    }
}
