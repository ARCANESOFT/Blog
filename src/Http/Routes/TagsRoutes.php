<?php

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Controllers\TagsController;

/**
 * Class     TagsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const TAG_WILDCARD = 'admin_blog_tag';

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
            $this->prefix('tags')->name('tags.')->group(function () {
                // admin::blog.tags.index
                $this->get('/', [TagsController::class, 'index'])
                     ->name('index');

                // admin::blog.tags.datatable
                $this->post('datatable', [TagsController::class, 'datatable'])
                     ->middleware(['ajax'])
                     ->name('datatable');

                // admin::blog.tags.metrics
                $this->get('metrics', [TagsController::class, 'metrics'])
                     ->name('metrics');

                // admin::blog.tags.create
                $this->get('create', [TagsController::class, 'create'])
                     ->name('create');

                // admin::blog.tags.store
                $this->post('store', [TagsController::class, 'store'])
                     ->name('store');

                $this->prefix('{'.static::TAG_WILDCARD.'}')->group(function () {
                    // admin::blog.tags.show
                    $this->get('/', [TagsController::class, 'show'])
                         ->name('show');

                    // admin::blog.tags.edit
                    $this->get('edit', [TagsController::class, 'edit'])
                         ->name('edit');

                    // admin::blog.tags.update
                    $this->put('update', [TagsController::class, 'update'])
                         ->name('update');

                    // admin::blog.tags.delete
                    $this->delete('delete', [TagsController::class, 'delete'])
                         ->name('delete');
                });
            });
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(): void
    {
        $this->bind(static::TAG_WILDCARD, function ($uuid) {
            return Blog::makeModel('tag')
                ->newQuery()
                ->where('uuid', '=', $uuid)
                ->firstOrFail();
        });
    }
}
