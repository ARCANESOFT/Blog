<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;
use Arcanesoft\Blog\Models\Category;

/**
 * Class     CategoriesRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Fixing the routes by solving the group issue and removing the `clear()` method.
 */
class CategoriesRoutes extends RouteRegistrar
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
        $this->clear()->prefix('categories')->name('categories.')->group(function () {
            $this->get('/', 'CategoriesController@index')
                 ->name('index');       // admin::blog.categories.index

            $this->get('trash', 'CategoriesController@trash')
                 ->name('trash');       // admin::blog.categories.trash

            $this->get('create', 'CategoriesController@create')
                 ->name('create');      // admin::blog.categories.create

            $this->post('store', 'CategoriesController@store')
                 ->name('store');       // admin::blog.categories.store

            $this->clear()->prefix('{blog_category}')->group(function () {
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
