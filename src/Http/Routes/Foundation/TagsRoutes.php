<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     TagsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Foundation
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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $this->group([
            'prefix'    => 'tags',
            'as'        => 'tags.',
        ], function () {
            $this->get('/', [
                'as'   => 'index', // blog::foundation.tags.index
                'uses' => 'TagsController@index',
            ]);
        });
    }
}
