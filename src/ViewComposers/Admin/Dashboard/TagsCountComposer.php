<?php namespace Arcanesoft\Blog\ViewComposers\Admin\Dashboard;

use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     TagsCountComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsCountComposer extends AbstractComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::admin._composers.dashboard.tags-total-box';

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
        $view->with('tagsCount', $this->cachedTags()->count());
    }
}
