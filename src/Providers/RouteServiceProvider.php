<?php namespace Arcanesoft\Blog\Providers;

use Arcanesoft\Blog\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;
use Illuminate\Contracts\Routing\Registrar as Router;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Router $router)
    {
        $this->mapAdminRoutes();
        $this->mapPublicRoutes();
    }

    /**
     * Define the foundation routes for the application.
     */
    private function mapAdminRoutes()
    {
        $attributes = $this->getAdminAttributes(
            'blog.',
            'Arcanesoft\\Blog\\Http\\Controllers\\Admin',
            $this->config()->get('arcanesoft.blog.route.prefix', 'blog')
        );

        $this->group($attributes, function () {
            Routes\Admin\StatsRoutes::register();
            Routes\Admin\PostsRoutes::register();
            Routes\Admin\CommentsRoutes::register();
            Routes\Admin\CategoriesRoutes::register();
            Routes\Admin\TagsRoutes::register();
        });
    }

    /**
     * Define the public routes for the application.
     */
    private function mapPublicRoutes()
    {
        $attributes = [
            'as'         => 'public::blog.',
            'prefix'     => 'blog',
            'middleware' => 'web',
            'namespace'  => 'Arcanesoft\\Blog\\Http\\Controllers\\Front',
        ];

        $this->group($attributes, function () {
            Routes\Front\PostsRoutes::register();
            Routes\Front\CategoriesRoutes::register();
            Routes\Front\TagsRoutes::register();
        });
    }
}
