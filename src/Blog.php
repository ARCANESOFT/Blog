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
    public function isTranslatable()
    {
        return config('arcanesoft.blog.translatable.enabled', false);
    }

    /**
     * Get the supported locales.
     *
     * @return array
     */
    public function getSupportedLocalesKeys()
    {
        $default = [config('app.locale')];

        return $this->isTranslatable()
            ? array_unique(config('localization.supported-locales', $default))
            : $default;
    }

    /**
     * Check if the media manager is installed.
     *
     * @return bool
     */
    public function isMediaManagerInstalled()
    {
        return array_key_exists('Arcanesoft\Media\MediaServiceProvider', app()->getLoadedProviders());
    }

    protected function __clone()
    {
        // YOU ... SHALL NOT ... CLOOOOOONE!
    }
}
