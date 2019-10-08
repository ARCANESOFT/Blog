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

    protected static $instance = null;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the blog instance.
     *
     * @return Blog
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

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
        Route::name('public::blog.')
            ->prefix('blog')
            ->namespace('\\Arcanesoft\\Blog\\Http\\Controllers\\Front')
            ->group(function () {
                Routes\PostsRoutes::register();
                Routes\CategoriesRoutes::register();
                Routes\TagsRoutes::register();
            });
    }

    /**
     * Check if the blog is translatable.
     *
     * @return bool
     */
    public static function isTranslatable()
    {
        return config('arcanesoft.blog.translatable.enabled', false);
    }

    /**
     * Check if the blog is seoable.
     *
     * @return bool
     */
    public static function isSeoable()
    {
        return config('arcanesoft.blog.seoable.enabled', false)
            && static::isSeoManagerInstalled();
    }

    /**
     * Get the supported locales.
     *
     * @return array
     */
    public static function getSupportedLocalesKeys()
    {
        $default = [config('app.locale')];

        return static::isTranslatable()
            ? array_unique(config('localization.supported-locales', $default))
            : $default;
    }

    /**
     * Check if the Media manager is installed.
     *
     * @return bool
     */
    public static function isMediaManagerInstalled()
    {
        return static::hasRegisteredProvider('Arcanesoft\\Media\\MediaServiceProvider');
    }

    /**
     * Check if the SEO manager is installed.
     *
     * @return bool
     */
    public static function isSeoManagerInstalled()
    {
        return static::hasRegisteredProvider('Arcanesoft\\Seo\\SeoServiceProvider');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the provider was registered in the container.
     *
     * @param  string  $provider
     *
     * @return bool
     */
    protected static function hasRegisteredProvider($provider)
    {
        return array_key_exists($provider, app()->getLoadedProviders());
    }

    protected function __clone()
    {
        // YOU ... SHALL NOT ... CLOOOOOONE!
    }
}
