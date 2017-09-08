<?php namespace Arcanesoft\Blog\Events\Categories;

/**
 * Class     AbstractCategoryEvent
 *
 * @package  Arcanesoft\Blog\Events\Categories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractCategoryEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Blog\Models\Category */
    public $category;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AbstractCategoryEvent constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Category  $category
     */
    public function __construct($category)
    {
        $this->category = $category;
    }
}
