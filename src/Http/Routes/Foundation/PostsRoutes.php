<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Foundation
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
        $this->group([
            'prefix'    => 'posts',
            'as'        => 'posts.',
        ], function () {
            $this->get('/', [
                'as'   => 'index', // blog::foundation.posts.index
                'uses' => 'PostsController@index',
            ]);
        });
    }
}
