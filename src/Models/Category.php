<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\Localization\Traits\HasTranslations;
use Arcanesoft\Blog\Blog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Arcanesoft\Blog\Events\Categories as CategoryEvents;

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
class Category extends AbstractModel
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const SELECT_CACHE_NAME = 'blog::categories.select-data';

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
    protected $table = 'categories';

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
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
     * Create a new category.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public static function createOne(array $attributes)
    {
        return tap(new self, function (self $category) use ($attributes) {
            $category->populate($attributes)->save();
        });
    }

    /**
     * Update the current category.
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
     * @param  bool  $placeholder
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions($placeholder = true)
    {
        /** @var  \Illuminate\Database\Eloquent\Collection  $categories */
        $categories = cache()->remember(self::SELECT_CACHE_NAME, 5, function () {
            return self::all()->keyBy('id')->transform(function (Category $category) {
                return  Blog::instance()->isTranslatable()
                    ? implode(' / ', $category->getTranslations('name'))
                    : $category->name;
            });
        });

        return $placeholder
            ? $categories->prepend(trans('blog::categories.select-category'), 0)
            : $categories;
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if category has posts.
     *
     * @return bool
     */
    public function hasPosts()
    {
        return ! $this->posts->isEmpty();
    }

    /**
     * Check if the category is deletable.
     *
     * @return bool
     */
    public function isDeletable()
    {
        return ! $this->hasPosts();
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
