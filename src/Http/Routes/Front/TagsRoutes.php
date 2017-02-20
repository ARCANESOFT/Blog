<?php namespace Arcanesoft\Blog\Http\Routes\Front;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     TagsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsRoutes extends RouteRegistrar
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
        $this->prefix('tags')->name('tags.')->group(function () {
            $this->get('{slug}', 'TagsController@show')
                 ->name('show'); // public::blog.tags.show
        });
    }
}
