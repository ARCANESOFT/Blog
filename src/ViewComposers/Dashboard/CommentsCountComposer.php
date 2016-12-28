<?php namespace Arcanesoft\Blog\ViewComposers\Dashboard;

use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     CommentsCountComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommentsCountComposer extends AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::admin._composers.dashboard.comments-total-box';

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
//        $comments = $this->cachedComments();
//        $view->with('', $comments->count());

        $view->with('commentsCount', rand(1000, 2000));
    }

    /**
     * Get the cached comments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
//    protected function cachedComments()
//    {
//        return $this->cacheResults('comments.all', function () {
//            return Comment::all();
//        });
//    }
}
