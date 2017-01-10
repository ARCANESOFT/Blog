<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\LaravelSeo\Traits\Seoable;
use Arcanesoft\Blog\Entities\PostStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
 *
 * @method  static  \Illuminate\Database\Eloquent\Builder  published()
 * @method  static  \Illuminate\Database\Eloquent\Builder  publishedAt(int $year)
 */
class Post extends AbstractModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Seoable, SoftDeletes;

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
     |  Scopes
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Scope only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public function scopePublished(Builder $builder)
    {
        $builder->where('status', PostStatus::STATUS_PUBLISHED)
                ->where('publish_date', '<=', Carbon::now());
    }

    /**
     * Scope only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  int                                    $year
     */
    public function scopePublishedAt(Builder $builder, $year)
    {
        $this->scopePublished($builder);
        $builder->where(DB::raw('YEAR(publish_date)'), $year);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Relationships
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(
            config('auth.providers.users.model', \App\Models\User::class),
            'author_id'
        );
    }

    /**
     * Category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Tags relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, "{$this->prefix}post_tag");
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
        $this->attributes['slug']  = Str::slug($title);
    }

    /**
     * Get the status name attribute.
     *
     * @return string|null
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
        ] + Arr::only($inputs, [
            'title', 'excerpt', 'content', 'publish_date', 'status'
        ]);

        $this->fill($attributes);
        $saved = $this->save();
        $this->tags()->sync($inputs['tags']);

        $this->createSeo(
            $this->extractSeoAttributes($inputs)
        );

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
        $attributes = ['category_id' => $inputs['category']] + Arr::only($inputs, [
            'title', 'excerpt', 'content', 'publish_date', 'status'
        ]);

        $updated = $this->update($attributes);
        $this->tags()->sync($inputs['tags']);

        $seoAttributes = $this->extractSeoAttributes($inputs);
        $this->hasSeo() ? $this->updateSeo($seoAttributes) : $this->createSeo($seoAttributes);

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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Extract the seo attributes.
     *
     * @param  array  $inputs
     *
     * @return array
     */
    protected function extractSeoAttributes(array $inputs)
    {
        return [
            'title'       => Arr::get($inputs, 'seo_title'),
            'description' => Arr::get($inputs, 'seo_description'),
            'keywords'    => Arr::get($inputs, 'seo_keywords'),
            'metas'       => Arr::get($inputs, 'seo_metas'),
        ];
    }
}
