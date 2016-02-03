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
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the routes namespace
     *
     * @return string
     */
    protected function getRouteNamespace()
    {
        return 'Arcanesoft\\Blog\\Http\\Routes';
    }

    /**
     * Get the auth foundation route prefix.
     *
     * @return string
     */
    public function getFoundationBlogPrefix()
    {
        $prefix = array_get($this->getFoundationRouteGroup(), 'prefix', 'dashboard');

        return "$prefix/" . config('arcanesoft.blog.route.prefix', 'blog');
    }

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
        $this->mapFoundationRoutes($router);
    }

    /**
     * Define the public routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapPublicRoutes(Router $router)
    {
        //
    }

    /**
     * Define the foundation routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapFoundationRoutes(Router $router)
    {
        $attributes = array_merge($this->getFoundationRouteGroup(), [
            'as'        => 'blog::foundation.',
            'namespace' => 'Arcanesoft\\Blog\\Http\\Controllers\\Foundation',
        ]);

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getFoundationBlogPrefix()]
        ), function (Router $router) {
            Routes\Foundation\StatsRoutes::register($router);
            Routes\Foundation\PostsRoutes::register($router);
            Routes\Foundation\CommentsRoutes::register($router);
            Routes\Foundation\CategoriesRoutes::register($router);
            Routes\Foundation\TagsRoutes::register($router);
        });
    }
}
