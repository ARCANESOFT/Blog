<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\ServiceProvider;
use Arcanesoft\Blog\ViewComposers\Dashboard;
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
        $this->registerDashboardComposers();
        //$this->registerOtherComposers();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Composers
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the dashboard composers.
     */
    private function registerDashboardComposers()
    {
        $this->composer(
            Dashboard\PostsCountComposer::VIEW,
            Dashboard\PostsCountComposer::class
        );

        $this->composer(
            Dashboard\CategoriesCountComposer::VIEW,
            Dashboard\CategoriesCountComposer::class
        );

        $this->composer(
            Dashboard\CategoriesRatiosComposer::VIEW,
            Dashboard\CategoriesRatiosComposer::class
        );

        $this->composer(
            Dashboard\TagsCountComposer::VIEW,
            Dashboard\TagsCountComposer::class
        );

        $this->composer(
            Dashboard\TagsRatiosComposer::VIEW,
            Dashboard\TagsRatiosComposer::class
        );

        $this->composer(
            Dashboard\CommentsCountComposer::VIEW,
            Dashboard\CommentsCountComposer::class
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
