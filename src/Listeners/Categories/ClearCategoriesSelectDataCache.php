<?php namespace Arcanesoft\Blog\Listeners\Categories;

use Arcanesoft\Blog\Events\Categories\AbstractCategoryEvent;
use Arcanesoft\Blog\Models\Category;

/**
 * Class     ClearCategoriesCache
 *
 * @package  Arcanesoft\Blog\Listeners\Categories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ClearCategoriesSelectDataCache
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the event.
     *
     * @param  \Arcanesoft\Blog\Events\Categories\AbstractCategoryEvent  $event
     */
    public function handle(AbstractCategoryEvent $event)
    {
        cache()->forget(Category::SELECT_CACHE_NAME);
    }
}
