<?php namespace Arcanesoft\Blog\Http\Routes\Front;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('posts')->name('posts.')->group(function () {
            $this->get('/', 'PostsController@index')
                 ->name('index');   // public::blog.posts.index

            $this->get('{slug}', 'PostsController@show')
                 ->name('show');    // public::blog.posts.show

            $this->get('{year}', 'PostsController@archive')
                 ->name('archive'); // public::blog.posts.archive
        });
    }
}
