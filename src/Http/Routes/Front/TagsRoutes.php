<?php namespace Arcanesoft\Blog\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     TagsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar $router
     */
    public function map(Registrar $router)
    {
        $this->group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            $this->get('{slug}', 'TagsController@show')->name('show'); // public::blog.tags.show
        });
    }
}
