<?php namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Events\Categories as CategoryEvents;

/**
 * Class     Category
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Category extends AbstractTaxonomy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const SELECT_CACHE_NAME = 'blog::categories.select-data';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating'  => CategoryEvents\CategoryCreating::class,
        'created'   => CategoryEvents\CategoryCreated::class,
        'updating'  => CategoryEvents\CategoryUpdating::class,
        'updated'   => CategoryEvents\CategoryUpdated::class,
        'saving'    => CategoryEvents\CategorySaving::class,
        'saved'     => CategoryEvents\CategorySaved::class,
        'deleting'  => CategoryEvents\CategoryDeleting::class,
        'deleted'   => CategoryEvents\CategoryDeleted::class,
        'restoring' => CategoryEvents\CategoryRestoring::class,
        'restored'  => CategoryEvents\CategoryRestored::class,
    ];

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Relationship with posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the categories options for select input.
     *
     * @param  bool  $placeholder
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getSelectData($placeholder = true)
    {
        $minutes = config('arcanesoft.blog.cache.categories.select-data', 5);

        /** @var  \Illuminate\Database\Eloquent\Collection  $categories */
        return cache()->remember(self::SELECT_CACHE_NAME, $minutes, function () {
                $withTranslations = Blog::instance()->isTranslatable();

                return self::all()->mapWithKeys(function (Category $category) use ($withTranslations) {
                    return [
                        $category->id => $withTranslations
                            ? implode(' / ', $category->getTranslations('name'))
                            : $category->name
                    ];
                });
            })
            ->toBase()->when($placeholder, function ($categories) {
                /** @var  \Illuminate\Support\Collection  $categories */
                return $categories->prepend(trans('blog::categories.select-category'), 0);
            });
    }
}
