<?php namespace Arcanesoft\Blog;

use Arcanesoft\Core\Bases\PackageServiceProvider;
use Illuminate\Support\Arr;

/**
 * Class     BlogServiceProvider
 *
 * @package  Arcanesoft\Blog
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BlogServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'blog';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();
        $this->registerSidebarItems();
        
        $this->registerProviders([
            Providers\AuthorizationServiceProvider::class,
            Providers\ViewComposerServiceProvider::class,
            Providers\RouteServiceProvider::class,
            \Arcanedev\LaravelMarkdown\LaravelMarkdownServiceProvider::class,
        ]);
        $this->registerConsoleServiceProvider(Providers\CommandServiceProvider::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->registerObservers();

        // Publishes
        $this->publishConfig();
        $this->publishViews();
        $this->publishTranslations();
        $this->publishSidebarItems();

        Blog::$runsMigrations ? $this->loadMigrations() : $this->publishMigrations();
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

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the observers.
     */
    private function registerObservers()
    {
        $config = $this->config()->get('arcanesoft.blog');

        foreach (Arr::only($config, ['posts', 'categories', 'tags']) as $entity) {
            $this->app->make($entity['model'])->observe($entity['observer']);
        }
    }
}
