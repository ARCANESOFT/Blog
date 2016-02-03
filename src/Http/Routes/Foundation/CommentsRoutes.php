<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     CommentsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommentsRoutes extends RouteRegister
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
            'prefix'    => 'comments',
            'as'        => 'comments.',
        ], function () {
            //
        });
    }
}
