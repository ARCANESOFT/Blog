<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\Localization\Traits\HasTranslations;
use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Events\Tags as TagEvents;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class     Category
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int             id
 * @property  string          name
 * @property  string          slug
 * @property  \Carbon\Carbon  created_at
 * @property  \Carbon\Carbon  updated_at
 * @property  \Carbon\Carbon  deleted_at
 *
 * @property  \Illuminate\Database\Eloquent\Collection  posts
 */
class Tag extends AbstractModel
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const SELECT_CACHE_NAME = 'blog::tags.select-data';

    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use SoftDeletes,
        HasTranslations;

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
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
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
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the name attribute.
     *
     * @param  string  $name
     *
     * @return string
     */
    public function setNameAttribute($name)
    {
        return $this->attributes['name'] = $name;
    }

    /**
     * Set the slug attribute.
     *
     * @param  string  $name
     *
     * @return string
     */
    public function setSlugAttribute($name)
    {
        return $this->attributes['slug'] = Str::slug($name);
    }

    /**
     * Get the translatable attributes.
     *
     * @return array
     */
    public function getTranslatableAttributes()
    {
        return Blog::instance()->isTranslatable() ? ['name', 'slug'] : [];
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a new tag.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public static function createOne(array $attributes)
    {
        return tap(new self, function (self $tag) use ($attributes) {
            $tag->populate($attributes)->save();
        });
    }

    /**
     * Update the current tag.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public function updateOne(array $attributes)
    {
        $this->populate($attributes)->save();

        return $this;
    }

    /**
     * Get the categories options for select input.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        return cache()->remember(self::SELECT_CACHE_NAME, 5, function () {
            return self::all()->keyBy('id')->transform(function (Tag $tag) {
                return Blog::instance()->isTranslatable()
                    ? implode(' / ', $tag->getTranslations('name'))
                    : $tag->name;
            });
        });
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if tag has posts.
     *
     * @return bool
     */
    public function hasPosts()
    {
        return ! $this->posts->isEmpty();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    protected function populate(array $attributes)
    {
        if ( ! Blog::instance()->isTranslatable())
            return $this->fill($attributes);

        $this->setTranslations('name', $attributes['name'])
             ->setTranslations('slug', $attributes['name']);

        return $this->fill(Arr::except($attributes, ['name', 'slug']));
    }
}
