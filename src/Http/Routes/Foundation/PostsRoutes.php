<?php namespace Arcanesoft\Blog\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Blog\Models\Post;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends RouteRegister
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
            'prefix'    => 'posts',
            'as'        => 'posts.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',         // blog::foundation.posts.index
                'uses' => 'PostsController@index',
            ]);

            $this->get('trashed', [
                'as'   => 'trash',         // blog::foundation.posts.trash
                'uses' => 'PostsController@trash',
            ]);

            $this->get('create', [
                'as'   => 'create',        // blog::foundation.posts.create
                'uses' => 'PostsController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',         // blog::foundation.posts.store
                'uses' => 'PostsController@store',
            ]);

            $this->group([
                'prefix' => '{blog_post_id}',
            ], function () {
                $this->get('show', [
                    'as'   => 'show',      // blog::foundation.posts.show
                    'uses' => 'PostsController@show',
                ]);

                $this->get('edit', [
                    'as'   => 'edit',      // blog::foundation.posts.edit
                    'uses' => 'PostsController@edit',
                ]);

                $this->put('update', [
                    'as'   => 'update',    // blog::foundation.posts.update
                    'uses' => 'PostsController@update',
                ]);

                $this->put('publish', [
                    'as'   => 'publish',   // blog::foundation.posts.activate
                    'uses' => 'PostsController@publish',
                ]);

                $this->put('restore', [
                    'as'   => 'restore',   // blog::foundation.posts.restore
                    'uses' => 'PostsController@restore',
                ]);

                $this->delete('delete', [
                    'as'   => 'delete',    // blog::foundation.posts.delete
                    'uses' => 'PostsController@delete',
                ]);
            });
        });

        $this->bind('blog_post_id', function($postId) {
            return Post::findOrFail($postId);
        });
    }
}
