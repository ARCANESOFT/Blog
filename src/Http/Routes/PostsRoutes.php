<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Http\Controllers\PostsController;

/**
 * Class     PostsRoutes
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    public const POST_WILDCARD = 'admin_blog_post';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->prefix('posts')->name('posts.')->group(function (): void {
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
    }
}
