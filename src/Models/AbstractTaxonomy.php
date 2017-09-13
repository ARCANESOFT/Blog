<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\Localization\Traits\HasTranslations;
use Arcanesoft\Blog\Blog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class     AbstractTaxonomy
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
abstract class AbstractTaxonomy extends AbstractModel
{
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
     * Create a new taxonomy (category or tag).
     *
     * @param  array  $attributes
     *
     * @return static
     */
    public static function createOne(array $attributes)
    {
        return tap(new static, function (self $taxonomy) use ($attributes) {
            $attributes['slug'] = $attributes['slug'] ?? $attributes['name'];

            $taxonomy->populate($attributes)->save();
        });
    }

    /**
     * Create many taxonomies (categories or tags).
     *
     * @param  array  $taxonomies
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createMany(array $taxonomies)
    {
        return collect($taxonomies)->transform(function ($attributes) {
            return static::createOne($attributes);
        });
    }

    /**
     * Update the current taxonomy (category or tag).
     *
     * @param  array  $attributes
     *
     * @return static
     */
    public function updateOne(array $attributes)
    {
        $this->populate($attributes)->save();

        return $this;
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
     * @return static
     */
    protected function populate(array $attributes)
    {
        if ( ! empty($keys = $this->getTranslatableAttributes())) {
            foreach ($keys as $key) {
                $this->setTranslations($key, $attributes[$key] ?? []);
            }

            $attributes = Arr::except($attributes, $keys);
        }

        return $this->fill($attributes);
    }
}
