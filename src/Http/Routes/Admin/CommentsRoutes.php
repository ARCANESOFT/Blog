<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     CommentsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommentsRoutes extends RouteRegistrar
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('comments')->name('comments.')->group(function () {
            //
        });
    }
}
