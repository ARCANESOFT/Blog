<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Blog;

/**
 * Class     Post
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int                         id
 * @property  int                         author_id
 * @property  string                      title
 * @property  string                      slug
 * @property  string                      excerpt
 * @property  string                      body
 * @property  string                      thumbnail
 * @property  string                      thumbnail_caption
 * @property  array                       meta
 * @property  \Illuminate\Support\Carbon  created_at
 * @property  \Illuminate\Support\Carbon  updated_at
 * @property  \Illuminate\Support\Carbon  published_at
 *
 * @property-read  \Arcanesoft\Blog\Models\Author            author
 * @property-read  \Illuminate\Database\Eloquent\Collection  tags
 */
class Post extends Model
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\PostPresenter;

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
        'author_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'thumbnail',
        'thumbnail_caption',
        'meta',
        'published_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'author_id' => 'integer',
        'meta'      => 'array',
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
        $this->setTable(Blog::table('posts'));

        parent::__construct($attributes);
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Author's relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(
            Blog::model('author', Author::class),
            'author_id'
        );
    }

    /**
     * Tags' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Blog::model('tag', Tag::class),
            Blog::table('post_tag', 'post_tag'),
            'post_id',
            'tag_id'
        )
            ->using(Pivots\PostTag::class)
            ->as('post_tag');
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope a query to only include published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include drafts (unpublished posts).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->whereNull('published_at');
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the post is deletable.
     *
     * @return bool
     */
    public function isDeletable(): bool
    {
        return true;
    }

    /**
     * Check if the post is not deletable.
     *
     * @return bool
     */
    public function isNotDeletable(): bool
    {
        return ! $this->isDeletable();
    }

    /**
     * Check if the post is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isDraft();
    }

    /**
     * Check if the post is a draft.
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return is_null($this->published_at);
    }
}
