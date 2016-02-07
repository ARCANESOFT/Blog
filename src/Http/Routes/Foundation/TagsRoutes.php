<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Blog\Models\Tag;
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
                'as'   => 'index',         // blog::foundation.tags.index
                'uses' => 'TagsController@index',
            ]);

            $this->get('trash', [
                'as'   => 'trash',         // blog::foundation.tags.trash
                'uses' => 'TagsController@trash',
            ]);

            $this->get('create', [
                'as'   => 'create',        // blog::foundation.tags.create
                'uses' => 'TagsController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',         // blog::foundation.tags.store
                'uses' => 'TagsController@store',
            ]);

            $this->group([
                'prefix' => '{blog_tag_id}',
            ], function () {
                $this->get('/', [
                    'as'   => 'show',      // blog::foundation.tags.show
                    'uses' => 'TagsController@show',
                ]);

                $this->get('edit', [
                    'as'   => 'edit',      // blog::foundation.tags.edit
                    'uses' => 'TagsController@edit',
                ]);

                $this->put('update', [
                    'as'   => 'update',    // blog::foundation.tags.update
                    'uses' => 'TagsController@update',
                ]);

                $this->put('restore', [
                    'as'   => 'restore',   // blog::foundation.tags.restore
                    'uses' => 'TagsController@restore',
                ]);

                $this->delete('delete', [
                    'as'   => 'delete',    // blog::foundation.tags.delete
                    'uses' => 'TagsController@delete',
                ]);
            });
        });

        $this->bind('blog_tag_id', function ($id) {
            return Tag::findOrFail($id);
        });
    }
}
