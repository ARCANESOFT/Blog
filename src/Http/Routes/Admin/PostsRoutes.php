<?php namespace Arcanesoft\Blog\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;
use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends RouteRegistrar
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
        (new static)->bind('blog_post', function($postId) {
            return Post::query()->withTrashed()->findOrFail($postId);
        });
    }

    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('posts')->name('posts.')->group(function () {
            $this->get('/', 'PostsController@index')
                 ->name('index');       // admin::blog.posts.index

            $this->get('trash', 'PostsController@trash')
                 ->name('trash');       // admin::blog.posts.trash

            $this->get('create', 'PostsController@create')
                 ->name('create');      // admin::blog.posts.create

            $this->post('store', 'PostsController@store')
                 ->name('store');       // admin::blog.posts.store

            $this->prefix('{blog_post}')->group(function () {
                $this->get('show', 'PostsController@show')
                     ->name('show');    // admin::blog.posts.show

                $this->get('edit', 'PostsController@edit')
                     ->name('edit');    // admin::blog.posts.edit

                $this->put('update', 'PostsController@update')
                     ->name('update');  // admin::blog.posts.update

                $this->put('publish', 'PostsController@publish')
                     ->middleware('ajax')
                     ->name('publish'); // admin::blog.posts.activate

                $this->put('restore', 'PostsController@restore')
                     ->middleware('ajax')
                     ->name('restore'); // admin::blog.posts.restore

                $this->delete('delete', 'PostsController@delete')
                     ->middleware('ajax')
                     ->name('delete');  // admin::blog.posts.delete
            });
        });
    }
}
