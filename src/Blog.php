<?php namespace Arcanesoft\Blog;

use Arcanesoft\Blog\Http\Routes\Front as Routes;
use Illuminate\Support\Facades\Route;

/**
 * Class     Blog
 *
 * @package  Arcanesoft\Blog
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Blog
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Indicates if migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Publish the migrations.
     */
    public static function publishMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * Register the public blog routes.
     */
    public static function routes()
    {
        Route::middleware('web')
            ->name('public::blog.')
            ->prefix('blog')
            ->namespace('Arcanesoft\\Blog\\Http\\Controllers\\Front')
            ->group(function () {
                Routes\PostsRoutes::register();
                Routes\CategoriesRoutes::register();
                Routes\TagsRoutes::register();
            });
    }
}
