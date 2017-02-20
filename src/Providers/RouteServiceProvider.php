<?php namespace Arcanesoft\Blog\Providers;

use Arcanesoft\Blog\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The admin controller namespace for the application.
     *
     * @var string
     */
    protected $adminNamespace = 'Arcanesoft\\Blog\\Http\\Controllers\\Admin';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->adminGroup(function () {
            $this->mapAdminRoutes();
        });
    }

    /**
     * Define the foundation routes for the application.
     */
    private function mapAdminRoutes()
    {
        $this->name('blog.')
             ->prefix($this->config()->get('arcanesoft.blog.route.prefix', 'blog'))
             ->group(function () {
                 Routes\Admin\StatsRoutes::register();
                 Routes\Admin\PostsRoutes::register();
                 Routes\Admin\CommentsRoutes::register();
                 Routes\Admin\CategoriesRoutes::register();
                 Routes\Admin\TagsRoutes::register();
            });
    }
}
