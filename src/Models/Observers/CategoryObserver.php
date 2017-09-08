<?php namespace Arcanesoft\Blog\Models\Observers;

use Arcanesoft\Blog\Models\Category;

/**
 * Class     CategoryObserver
 *
 * @package  Arcanesoft\Blog\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Replace Observers by Events/Listeners
 */
class CategoryObserver extends AbstractObserver
{
    /* -----------------------------------------------------------------
     |  Events
     | -----------------------------------------------------------------
     */

    /**
     * Listen to the Tag saved event.
     *
     * @param  \Arcanesoft\Blog\Models\Category  $category
     */
    public function saved(Category $category)
    {
        $category->clearCache();
    }

    /**
     * Listen to the Category deleted event.
     *
     * @param  \Arcanesoft\Blog\Models\Category  $category
     */
    public function deleted(Category $category)
    {
        $category->clearCache();
    }
}
