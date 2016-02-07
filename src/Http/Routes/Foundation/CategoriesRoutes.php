<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Blog\Models\Category;
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
                'as'   => 'index',         // blog::foundation.categories.index
                'uses' => 'CategoriesController@index',
            ]);

            $this->get('trash', [
                'as'   => 'trash',         // blog::foundation.categories.trash
                'uses' => 'CategoriesController@trash',
            ]);

            $this->get('create', [
                'as'   => 'create',        // blog::foundation.categories.create
                'uses' => 'CategoriesController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',         // blog::foundation.categories.store
                'uses' => 'CategoriesController@store',
            ]);

            $this->group([
                'prefix' => '{blog_category_id}',
            ], function () {
                $this->get('/', [
                    'as'   => 'show',      // blog::foundation.categories.show
                    'uses' => 'CategoriesController@show',
                ]);

                $this->get('edit', [
                    'as'   => 'edit',      // blog::foundation.categories.edit
                    'uses' => 'CategoriesController@edit',
                ]);

                $this->put('update', [
                    'as'   => 'update',    // blog::foundation.categories.update
                    'uses' => 'CategoriesController@update',
                ]);

                $this->put('restore', [
                    'as'   => 'restore',   // blog::foundation.categories.restore
                    'uses' => 'CategoriesController@restore',
                ]);

                $this->delete('delete', [
                    'as'   => 'delete',    // blog::foundation.categories.delete
                    'uses' => 'CategoriesController@delete',
                ]);
            });
        });

        $this->bind('blog_category_id', function ($id) {
            return Category::findOrFail($id);
        });
    }
}
