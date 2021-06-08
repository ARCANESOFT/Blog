<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Blog;
use Illuminate\Support\Str;

/**
 * Class     Tag
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int                         id
 * @property  string                      name
 * @property  string                      slug
 * @property  array                       meta
 * @property  \Illuminate\Support\Carbon  created_at
 * @property  \Illuminate\Support\Carbon  updated_at
 *
 * @property-read  \Arcanesoft\Blog\Models\Post[]|\Illuminate\Database\Eloquent\Collection  $posts
 * @property-read  int                                                                      $posts_count
 */
class Tag extends Model
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'meta',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'   => 'integer',
        'meta' => 'array',
    ];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(Blog::table('tags'));

        parent::__construct($attributes);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Set the `slug` attribute.
     *
     * @param  string  $slug
     */
    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = Str::slug($slug);
    }
    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Posts' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(
            Blog::model('post', Post::class),
            Blog::table('post_tag', 'post_tag'),
            'tag_id',
            'post_id'
        )
            ->using(Pivots\PostTag::class)
            ->as('post_tag');
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the tag is deletable.
     *
     * @return bool
     */
    public function isDeletable(): bool
    {
        return true;
    }

    /**
     * Check if the tag is not deletable.
     *
     * @return bool
     */
    public function isNotDeletable(): bool
    {
        return ! $this->isDeletable();
    }
}
