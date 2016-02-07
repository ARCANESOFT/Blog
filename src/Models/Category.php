<?php namespace Arcanesoft\Blog\Models;

use Arcanesoft\Blog\Bases\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 */
class Category extends Model
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
    protected $table    = 'categories';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Set or unset the timestamps for the model
     *
     * @var bool
     */
    public $timestamps  = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates    = ['deleted_at'];

    /* ------------------------------------------------------------------------------------------------
     |  Relationships
     | ------------------------------------------------------------------------------------------------
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

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the name attribute.
     *
     * @param  string  $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str_slug($name);
    }
}
