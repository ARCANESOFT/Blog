<?php namespace Arcanesoft\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
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
     |  Traits
     | -----------------------------------------------------------------
     */

    use SoftDeletes;

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
    protected $fillable = ['name'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
        return $this->belongsToMany(Post::class, $this->getPrefix()."post_tag");
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the name attribute.
     *
     * @param  string  $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the categories options for select input.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        return Cache::remember('blog_tags_select_options', 5, function () {
            return self::all()->pluck('name', 'id');
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
     * Clear the cached tags.
     */
    public static function clearCache()
    {
        cache()->forget('blog_tags_select_options');
    }
}
