<?php

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Controllers\AuthorsController;

/**
 * Class     AuthorsRoutes
 *
 * @package  Arcanesoft\Blog\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorsRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const AUTHOR_WILDCARD = 'admin_blog_author';

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
            $this->prefix('authors')->name('authors.')->group(function () {
                // admin::blog.authors.index
                $this->get('/', [AuthorsController::class, 'index'])
                     ->name('index');

                // admin::blog.authors.datatable
                $this->post('datatable', [AuthorsController::class, 'datatable'])
                     ->middleware(['ajax'])
                     ->name('datatable');

                // admin::blog.authors.metrics
                $this->get('metrics', [AuthorsController::class, 'metrics'])
                     ->name('metrics');

                $this->get('create', [AuthorsController::class, 'create'])
                     ->name('create'); // admin::blog.authors.create

                $this->post('store', [AuthorsController::class, 'store'])
                     ->name('store'); // admin::blog.authors.store

                $this->prefix('{'.static::AUTHOR_WILDCARD.'}')->group(function () {
                    $this->get('/', [AuthorsController::class, 'show'])
                         ->name('show'); // admin::blog.authors.show

                    $this->get('edit', [AuthorsController::class, 'edit'])
                         ->name('edit'); // admin::blog.authors.edit

                    $this->put('update', [AuthorsController::class, 'update'])
                         ->name('update'); // admin::blog.authors.update

                    $this->delete('delete', [AuthorsController::class, 'delete'])
                         ->middleware(['ajax'])
                         ->name('delete'); // admin::blog.authors.delete
                });
            });
        });
    }

    /**
     * Register the bindings.
     */
    public function bindings(): void
    {
        $this->bind(static::AUTHOR_WILDCARD, function ($uuid) {
            return Blog::makeModel('author')
                ->where('uuid', $uuid)
                ->firstOrFail();
        });
    }
}
