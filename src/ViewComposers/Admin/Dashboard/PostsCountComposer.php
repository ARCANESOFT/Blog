<?php namespace Arcanesoft\Blog\ViewComposers\Admin\Dashboard;

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
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::admin._composers.dashboard.posts-total-box';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('postsCount', $this->cachedPosts()->count());
    }
}
