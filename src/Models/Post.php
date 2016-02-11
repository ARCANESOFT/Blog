<?php namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Bases\Model;
use Arcanesoft\Blog\Entities\PostStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class     Post
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int             id
 * @property  int             author_id
 * @property  int             category_id
 * @property  string          title
 * @property  string          slug
 * @property  string          excerpt
 * @property  string          content
 * @property  string          status
 * @property  \Carbon\Carbon  publish_date
 * @property  \Carbon\Carbon  created_at
 * @property  \Carbon\Carbon  updated_at
 * @property  \Carbon\Carbon  deleted_at
 *
 * @property  \Arcanesoft\Contracts\Auth\Models\User  user
 * @property  \Arcanesoft\Blog\Models\Category        category
 */
class Post extends Model
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use SoftDeletes;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'category_id', 'title', 'excerpt', 'content', 'status', 'publish_date'
    ];

    /**
     * Set or unset the timestamps for the model
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['publish_date', 'deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'author_id'   => 'integer',
        'category_id' => 'integer',
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Relationships
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Relationship with author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config('auth.model'), 'author_id');
    }

    /**
     * Relationship with category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship with tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, $this->prefix . 'post_tag');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the title attribute.
     *
     * @param  string  $title
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug']  = str_slug($title);
    }

    /**
     * Get the status name attribute.
     *
     * @return null|string
     */
    public function getStatusNameAttribute()
    {
        return PostStatus::get($this->status);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a post.
     *
     * @param  array  $inputs
     *
     * @return bool
     */
    public function createOne(array $inputs)
    {
        $attributes = [
            'author_id'   => auth()->user()->getAuthIdentifier(),
            'category_id' => $inputs['category'],
        ] + array_only($inputs, [
            'title', 'excerpt', 'content', 'publish_date', 'status'
        ]);

        $this->fill($attributes);
        $saved = $this->save();
        $this->tags()->sync($inputs['tags']);

        return $saved;
    }

    /**
     * Create a post.
     *
     * @param  array  $inputs
     *
     * @return bool|int
     */
    public function updateOne(array $inputs)
    {
        $attributes = [
            'category_id' => $inputs['category'],
        ] + array_only($inputs, [
            'title', 'excerpt', 'content', 'publish_date', 'status'
        ]);

        $updated = $this->update($attributes);
        $this->tags()->sync($inputs['tags']);

        return $updated;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the post's status is "draft".
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === PostStatus::STATUS_DRAFT;
    }

    /**
     * Check if the post's status is "published".
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === PostStatus::STATUS_PUBLISHED;
    }
}
