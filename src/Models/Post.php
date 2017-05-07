<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\LaravelSeo\Traits\Seoable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
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
 * @property  string          content_raw
 * @property  string          content_html
 * @property  bool            is_draft
 * @property  \Carbon\Carbon  published_at
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
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const STATUS_DRAFT     = 'draft';
    const STATUS_PUBLISHED = 'published';

    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\PostPresenter,
        Seoable,
        SoftDeletes;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
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
        'author_id', 'category_id', 'title', 'excerpt', 'content', 'published_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'author_id'   => 'integer',
        'category_id' => 'integer',
        'is_draft'    => 'boolean',
    ];

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public function scopePublished(Builder $builder)
    {
        $builder->where('is_draft', false)
                ->where('published_at', '<=', Carbon::now());
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
        $builder->where(DB::raw('YEAR(published_at)'), $year);
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
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

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
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
     * Set the content attribute.
     *
     * @param  string  $content
     */
    public function setContentAttribute($content)
    {
        $this->attributes['content_raw']  = $content;
        $this->attributes['content_html'] = markdown($content);
    }

    /**
     * Get the content attribute.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function getContentAttribute()
    {
        return new HtmlString($this->content_html);
    }

    /**
     * Set the status attribute.
     *
     * @param  string  $status
     */
    public function setStatusAttribute($status)
    {
        $this->attributes['is_draft'] = ($status === self::STATUS_DRAFT);
    }

    /**
     * Get the status name attribute.
     *
     * @return string|null
     */
    public function getStatusNameAttribute()
    {
        return self::getStatuses()->get(
            $this->isDraft() ? self::STATUS_DRAFT : self::STATUS_PUBLISHED
        );
    }

    /* -----------------------------------------------------------------
     |  Main Functions
     | -----------------------------------------------------------------
     */

    /**
     * Create a post.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public static function createOne(array $attributes)
    {
        $post = new self($attributes);

        $post->save();

        $post->tags()->sync($attributes['tags']);

        $post->createSeo(
            static::extractSeoAttributes($attributes)
        );

        return $post;
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
        $updated = $this->update(Arr::except($inputs, ['author_id']));

        $this->tags()->sync($inputs['tags']);

        $seoAttributes = static::extractSeoAttributes($inputs);

        $this->hasSeo() ? $this->updateSeo($seoAttributes) : $this->createSeo($seoAttributes);

        return $updated;
    }

    /* -----------------------------------------------------------------
     |  Check Functions
     | -----------------------------------------------------------------
     */

    /**
     * Check if the post's status is "draft".
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->is_draft;
    }

    /**
     * Check if the post's status is "published".
     *
     * @return bool
     */
    public function isPublished()
    {
        return ! $this->isDraft();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the post statuses.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getStatuses()
    {
        return Collection::make(
            trans('blog::posts.statuses', [])
        );
    }

    /**
     * Extract the seo attributes.
     *
     * @param  array  $inputs
     *
     * @return array
     */
    protected static function extractSeoAttributes(array $inputs)
    {
        return [
            'title'       => Arr::get($inputs, 'seo_title'),
            'description' => Arr::get($inputs, 'seo_description'),
            'keywords'    => Arr::get($inputs, 'seo_keywords'),
            'metas'       => Arr::get($inputs, 'seo_metas'),
        ];
    }

    /**
     * Get the show url.
     *
     * @return string
     */
    public function getShowUrl()
    {
        return route('admin::blog.posts.show', [$this]);
    }

    /**
     * Get the edit url.
     *
     * @return string
     */
    public function getEditUrl()
    {
        return route('admin::blog.posts.edit', [$this]);
    }
}
