<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\ServiceProvider;
use Arcanesoft\Blog\ViewComposers;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class     ViewComposerServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->registerAdminComposers();
        $this->registerFrontComposers();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Composers
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the front view composers.
     */
    private function registerFrontComposers()
    {
        $this->composer(
            ViewComposers\Front\Widgets\CategoriesWidgetComposer::VIEW,
            ViewComposers\Front\Widgets\CategoriesWidgetComposer::class
        );

        $this->composer(
            ViewComposers\Front\Widgets\TagsWidgetComposer::VIEW,
            ViewComposers\Front\Widgets\TagsWidgetComposer::class
        );

        $this->composer(
            ViewComposers\Front\Widgets\ArchivesWidgetComposer::VIEW,
            ViewComposers\Front\Widgets\ArchivesWidgetComposer::class
        );
    }

    /**
     * Register the admin view composers.
     */
    private function registerAdminComposers()
    {
        /**
         * Dashboards
         */
        $this->composer(
            ViewComposers\Admin\Dashboard\PostsCountComposer::VIEW,
            ViewComposers\Admin\Dashboard\PostsCountComposer::class
        );

        $this->composer(
            ViewComposers\Admin\Dashboard\CategoriesCountComposer::VIEW,
            ViewComposers\Admin\Dashboard\CategoriesCountComposer::class
        );

        $this->composer(
            ViewComposers\Admin\Dashboard\CategoriesRatiosComposer::VIEW,
            ViewComposers\Admin\Dashboard\CategoriesRatiosComposer::class
        );

        $this->composer(
            ViewComposers\Admin\Dashboard\TagsCountComposer::VIEW,
            ViewComposers\Admin\Dashboard\TagsCountComposer::class
        );

        $this->composer(
            ViewComposers\Admin\Dashboard\TagsRatiosComposer::VIEW,
            ViewComposers\Admin\Dashboard\TagsRatiosComposer::class
        );

        $this->composer(
            ViewComposers\Admin\Dashboard\CommentsCountComposer::VIEW,
            ViewComposers\Admin\Dashboard\CommentsCountComposer::class
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the view composer.
     *
     * @param  array|string     $views
     * @param  \Closure|string  $callback
     * @param  int|null         $priority
     *
     * @return array
     */
    protected function composer($views, $callback, $priority = null)
    {
        return $this->app[ViewFactory::class]->composer($views, $callback, $priority);
    }
}
