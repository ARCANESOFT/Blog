<?php namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Events\Tags as TagEvents;

/**
 * Class     Category
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Tag extends AbstractTaxonomy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const SELECT_CACHE_NAME = 'blog::tags.select-data';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating'  => TagEvents\TagCreating::class,
        'created'   => TagEvents\TagCreated::class,
        'updating'  => TagEvents\TagUpdating::class,
        'updated'   => TagEvents\TagUpdated::class,
        'saving'    => TagEvents\TagSaving::class,
        'saved'     => TagEvents\TagSaved::class,
        'deleting'  => TagEvents\TagDeleting::class,
        'deleted'   => TagEvents\TagDeleted::class,
        'restoring' => TagEvents\TagRestoring::class,
        'restored'  => TagEvents\TagRestored::class,
    ];

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Posts relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, $this->getPrefix().'post_tag');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the categories options for select input.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getSelectData()
    {
        $minutes = config('arcanesoft.blog.cache.tags.select-data', 5);

        /** @var  \Illuminate\Database\Eloquent\Collection  $categories */
        return cache()->remember(self::SELECT_CACHE_NAME, $minutes, function () {
            $withTranslations = Blog::instance()->isTranslatable();

            return self::all()->mapWithKeys(function (Tag $tag) use ($withTranslations) {
                return [
                    $tag->id => $withTranslations
                        ? implode(' / ', $tag->getTranslations('name'))
                        : $tag->name
                ];
            });
        })->toBase();
    }
}
