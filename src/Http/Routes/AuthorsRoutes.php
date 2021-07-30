<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Http\Controllers\AuthorsController;
use Arcanesoft\Blog\Repositories\AuthorsRepository;

/**
 * Class     AuthorsRoutes
 *
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
        $this->prefix('authors')->name('authors.')->group(function (): void {
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

            // admin::blog.authors.create
            $this->get('create', [AuthorsController::class, 'create'])
                 ->name('create');

            // admin::blog.authors.store
            $this->post('store', [AuthorsController::class, 'store'])
                 ->name('store');

            $this->prefix('{'.static::AUTHOR_WILDCARD.'}')->group(function () {
                // admin::blog.authors.show
                $this->get('/', [AuthorsController::class, 'show'])
                     ->name('show');

                // admin::blog.authors.edit
                $this->get('edit', [AuthorsController::class, 'edit'])
                     ->name('edit');

                // admin::blog.authors.update
                $this->put('update', [AuthorsController::class, 'update'])
                     ->name('update');

                // admin::blog.authors.delete
                $this->delete('delete', [AuthorsController::class, 'delete'])
                     ->middleware(['ajax'])
                     ->name('delete');
            });
        });
    }

    /**
     * Register the bindings.
     */
    public function bindings(AuthorsRepository $repo): void
    {
        $this->bind(static::AUTHOR_WILDCARD, function ($uuid) use ($repo) {
            return $repo->where('uuid', $uuid)->firstOrFail();
        });
    }
}
