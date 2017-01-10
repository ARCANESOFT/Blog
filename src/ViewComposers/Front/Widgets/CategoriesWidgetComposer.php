<?php namespace Arcanesoft\Blog\ViewComposers\Front\Widgets;

use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     CategoriesWidgetComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Front\Widgets
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesWidgetComposer extends AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::front._composers.widgets.categories-widget';

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
        $categories = Category::with('posts')
            ->whereHas('posts', function (Builder $b) {
                $b->where('status', PostStatus::STATUS_PUBLISHED)
                  ->where('publish_date', '<=', Carbon::now());
            })
            ->get()
            ->sortByDesc(function($category) {
                return $category->posts->count();
            });

        $view->with('categoriesWidgetItems', $categories);
    }
}
