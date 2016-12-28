<?php namespace Arcanesoft\Blog\ViewComposers;

use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Class     AbstractComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Caching time.
     *
     * @var int
     */
    protected $cacheMinutes = 5;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the cached posts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function cachedPosts()
    {
        return $this->cacheResults('posts.all', function () {
            return Post::all();
        });
    }

    /**
     * Get the cached categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function cachedCategories()
    {
        return $this->cacheResults('categories.all', function () {
            return Category::all();
        });
    }

    /**
     * Get the cached tags.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function cachedTags()
    {
        return $this->cacheResults('tags.all', function () {
            return Tag::all();
        });
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Cache the results.
     *
     * @param  string    $name
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    protected function cacheResults($name, Closure $callback)
    {
        return Cache::remember("blog::{$name}", $this->cacheMinutes, $callback);
    }
}
