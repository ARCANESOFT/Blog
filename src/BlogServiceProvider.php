<?php namespace Arcanesoft\Blog;

use Arcanesoft\Core\Bases\PackageServiceProvider;
use Arcanesoft\Core\CoreServiceProvider;

/**
 * Class     BlogServiceProvider
 *
 * @package  Arcanesoft\Blog
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BlogServiceProvider extends PackageServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'blog';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return str_slug($this->vendor . ' ' .$this->package, '.');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerSidebarItems();
        $this->app->register(CoreServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->app->register(Providers\CommandServiceProvider::class);
        }
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerPublishes();

        $this->app->register(Providers\RouteServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            //
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register publishes.
     */
    private function registerPublishes()
    {
        // Config
        $this->publishes([
            $this->getConfigFile() => config_path("{$this->vendor}/{$this->package}.php"),
        ], 'config');

        // Migrations
        $this->publishes([
            $this->getBasePath() . '/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Views
        $viewsPath = $this->getBasePath() . '/resources/views';

        $this->loadViewsFrom($viewsPath, $this->package);
        $this->publishes([
            $viewsPath => base_path("resources/views/vendor/{$this->package}"),
        ], 'views');

        // Translations
        $translationsPath = $this->getBasePath() . '/resources/lang';

        $this->loadTranslationsFrom($translationsPath, $this->package);
        $this->publishes([
            $translationsPath => base_path("resources/lang/vendor/{$this->package}"),
        ], 'lang');

        // Sidebar items
        $this->publishSidebarItems();
    }
}
