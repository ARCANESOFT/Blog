<?php

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Http\Controllers\PostsController;

/**
 * Class     PostsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->adminGroup(function () {
            $this->prefix('posts')->name('posts.')->group(function () {
                // admin::blog.posts.index
                $this->get('/', [PostsController::class, 'index'])
                     ->name('index');

                // admin::blog.posts.datatable
                $this->post('datatable', [PostsController::class, 'datatable'])
                     ->middleware(['ajax'])
                     ->name('datatable');

                // admin::blog.posts.metrics
                $this->get('metrics', [PostsController::class, 'metrics'])
                     ->name('metrics');

                // admin::blog.posts.create
                $this->get('create', [PostsController::class, 'create'])
                     ->name('create');

                // admin::blog.posts.store
                $this->post('store', [PostsController::class, 'store'])
                     ->name('store');
            });
        });
    }
}
