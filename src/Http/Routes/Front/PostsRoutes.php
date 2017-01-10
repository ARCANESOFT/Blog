<?php namespace Arcanesoft\Blog\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $this->group(['prefix' => 'posts', 'as' => 'posts.'], function () {
            $this->get('/', 'PostsController@index')->name('index');          // public::blog.posts.index
            $this->get('{slug}', 'PostsController@show')->name('show');       // public::blog.posts.show
            $this->get('{year}', 'PostsController@archive')->name('archive'); // public::blog.posts.archive
        });
    }
}
