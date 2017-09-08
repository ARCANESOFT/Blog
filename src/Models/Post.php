<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\LaravelSeo\Traits\Seoable;
use Arcanesoft\Blog\Events\Posts as PostEvents;
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
 * @property  string          locale
 * @property  string          title
 * @property  string          slug
 * @property  string          excerpt
 * @property  string|null     thumbnail
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
 * @method  static  \Illuminate\Database\Eloquent\Builder  localized(string|null $locale)
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
        'author_id', 'category_id', 'locale', 'title', 'excerpt', 'thumbnail', 'content', 'published_at',
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

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'creating'  => PostEvents\PostCreating::class,
        'created'   => PostEvents\PostCreated::class,
        'updating'  => PostEvents\PostUpdating::class,
        'updated'   => PostEvents\PostUpdated::class,
        'saving'    => PostEvents\PostSaving::class,
        'saved'     => PostEvents\PostSaved::class,
        'deleting'  => PostEvents\PostDeleting::class,
        'deleted'   => PostEvents\PostDeleted::class,
        'restoring' => PostEvents\PostRestoring::class,
        'restored'  => PostEvents\PostRestored::class,
    ];

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('is_draft', false)
                     ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Scope only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int                                    $year
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublishedAt(Builder $query, $year)
    {
        return $this->scopePublished($query)
                    ->where(DB::raw('YEAR(published_at)'), $year);
    }

    /**
     * Scope by post's locale.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null                            $locale
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLocalized(Builder $query, $locale = null)
    {
        return $query->where('locale', $locale ?: config('app.locale'));
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
            config('auth.providers.users.model', 'App\Models\User'),
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
        return tap(new self($attributes), function (self $post) use ($attributes) {
            $post->save();

            $post->tags()->sync($attributes['tags']);

            $post->createSeo(
                static::extractSeoAttributes($attributes)
            );
        });
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
        $updated = $this->setStatusAttribute($inputs['status'])
            ->update(Arr::except($inputs, ['author_id']));

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

    /**
     * Check if the post has thumbnail.
     *
     * @return bool
     */
    public function hasThumbnail()
    {
        return ! is_null($this->thumbnail);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

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
