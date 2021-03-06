<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;
use Arcanesoft\Blog\Models\Category;

/**
 * Class     CategoriesRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Route bindings.
     */
    public static function bindings()
    {
        (new static)->bind('blog_category', function ($id) {
            return Category::query()->withTrashed()->findOrFail($id);
        });
    }

    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('categories')->name('categories.')->group(function () {
            $this->get('/', 'CategoriesController@index')
                 ->name('index');       // admin::blog.categories.index

            $this->get('trash', 'CategoriesController@trash')
                 ->name('trash');       // admin::blog.categories.trash

            $this->get('create', 'CategoriesController@create')
                 ->name('create');      // admin::blog.categories.create

            $this->post('store', 'CategoriesController@store')
                 ->name('store');       // admin::blog.categories.store

            $this->prefix('{blog_category}')->group(function () {
                $this->get('/', 'CategoriesController@show')
                     ->name('show');    // admin::blog.categories.show

                $this->get('edit', 'CategoriesController@edit')
                    ->name('edit');     // admin::blog.categories.edit

                $this->put('update', 'CategoriesController@update')
                     ->name('update');  // admin::blog.categories.update

                $this->put('restore', 'CategoriesController@restore')
                     ->middleware('ajax')
                     ->name('restore'); // admin::blog.categories.restore

                $this->delete('delete', 'CategoriesController@delete')
                     ->middleware('ajax')
                     ->name('delete'); // admin::blog.categories.delete
            });
        });
    }
}
