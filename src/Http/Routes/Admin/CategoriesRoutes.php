<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Blog\Models\Category;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     CategoriesRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
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
        $this->group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            $this->get('/', 'CategoriesController@index')
                 ->name('index');       // admin::blog.categories.index

            $this->get('trash', 'CategoriesController@trash')
                 ->name('trash');       // admin::blog.categories.trash

            $this->get('create', 'CategoriesController@create')
                 ->name('create');      // admin::blog.categories.create

            $this->post('store', 'CategoriesController@store')
                 ->name('store');       // admin::blog.categories.store

            $this->group(['prefix' => '{blog_category}'], function () {
                $this->get('/', 'CategoriesController@show')
                     ->name('show');    // admin::blog.categories.show

                $this->get('edit', 'CategoriesController@edit')
                    ->name('edit');     // admin::blog.categories.edit

                $this->put('update', 'CategoriesController@update')
                     ->name('update');  // admin::blog.categories.update

                $this->put('restore', 'CategoriesController@restore')
                     ->name('restore'); // admin::blog.categories.restore

                $this->delete('delete', 'CategoriesController@delete')
                     ->name('delete'); // admin::blog.categories.delete
            });
        });

        $this->bind('blog_category', function ($id) {
            return Category::withTrashed()->findOrFail($id);
        });
    }
}
