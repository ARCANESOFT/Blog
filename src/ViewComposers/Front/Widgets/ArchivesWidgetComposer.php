<?php namespace Arcanesoft\Blog\ViewComposers\Front\Widgets;

use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     ArchivesWidgetComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Front\Widgets
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ArchivesWidgetComposer extends AbstractComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::front._composers.widgets.archives-widget';

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
        $archives = Post::published()->get()->groupBy(function (Post $post) {
            return $post->published_at->year;
        });

        $view->with('archivesWidgetItems', $archives);
    }
}
