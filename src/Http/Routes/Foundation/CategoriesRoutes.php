<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     CategoriesRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Foundation
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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $this->group([
            'prefix'    => 'categories',
            'as'        => 'categories.',
        ], function () {
            $this->get('/', [
                'as'   => 'index', // blog::foundation.categories.index
                'uses' => 'CategoriesController@index',
            ]);
        });
    }
}
