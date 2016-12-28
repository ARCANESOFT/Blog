<?php namespace Arcanesoft\Blog\ViewComposers\Dashboard;

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
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::admin._composers.dashboard.categories-total-box';

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
        $categories = $this->cachedCategories();

        $view->with('categoriesCount', $categories->count());
    }
}
