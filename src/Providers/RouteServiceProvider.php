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
        $this->mapPublicRoutes($router);
        $this->mapAdminRoutes($router);
    }

    /**
     * Define the public routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapPublicRoutes(Router $router)
    {
        $attributes = [
            'as'         => 'public::blog.',
            'prefix'     => 'blog',
            'middleware' => 'web',
            'namespace'  => 'Arcanesoft\\Blog\\Http\\Controllers\\Front',
        ];

        $router->group($attributes, function (Router $router) {
            Routes\Front\PostsRoutes::register($router);
            Routes\Front\CategoriesRoutes::register($router);
            Routes\Front\TagsRoutes::register($router);
        });
    }

    /**
     * Define the foundation routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapAdminRoutes(Router $router)
    {
        $attributes = $this->getAdminAttributes(
            'blog.',
            'Arcanesoft\\Blog\\Http\\Controllers\\Admin',
            $this->config()->get('arcanesoft.blog.route.prefix', 'blog')
        );

        $router->group($attributes, function (Router $router) {
            Routes\Admin\StatsRoutes::register($router);
            Routes\Admin\PostsRoutes::register($router);
            Routes\Admin\CommentsRoutes::register($router);
            Routes\Admin\CategoriesRoutes::register($router);
            Routes\Admin\TagsRoutes::register($router);
        });
    }
}
