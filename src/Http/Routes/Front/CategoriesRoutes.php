<?php namespace Arcanesoft\Blog\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     CategoriesRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesRoutes extends RouteRegister
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
        $this->group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            $this->get('{slug}', 'CategoriesController@show')->name('show'); // public::blog.categories.show
        });
    }
}
