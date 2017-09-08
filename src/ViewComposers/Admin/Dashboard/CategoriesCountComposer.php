<?php namespace Arcanesoft\Blog\ViewComposers\Admin\Dashboard;

use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     CategoriesCountComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesCountComposer extends AbstractComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::admin._composers.dashboard.categories-total-box';

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
        $view->with('categoriesCount', $this->cachedCategories()->count());
    }
}
