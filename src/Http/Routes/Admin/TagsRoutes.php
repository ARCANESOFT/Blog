<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     TagsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
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
        $this->group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            $this->get('/', 'TagsController@index')
                 ->name('index');       // admin::blog.tags.index

            $this->get('trash', 'TagsController@trash')
                 ->name('trash');       // admin::blog.tags.trash

            $this->get('create', 'TagsController@create')
                 ->name('create');      // admin::blog.tags.create

            $this->post('store', 'TagsController@store')
                 ->name('store');       // admin::blog.tags.store

            $this->group(['prefix' => '{blog_tag}'], function () {
                $this->get('/', 'TagsController@show')
                     ->name('show');    // admin::blog.tags.show

                $this->get('edit', 'TagsController@edit')
                     ->name('edit');    // admin::blog.tags.edit

                $this->put('update', 'TagsController@update')
                     ->name('update');  // admin::blog.tags.update

                $this->put('restore', 'TagsController@restore')
                     ->name('restore'); // admin::blog.tags.restore

                $this->delete('delete', 'TagsController@delete')
                     ->name('delete');  // admin::blog.tags.delete
            });
        });

        $this->bind('blog_tag', function ($id) {
            return Tag::withTrashed()->findOrFail($id);
        });
    }
}
