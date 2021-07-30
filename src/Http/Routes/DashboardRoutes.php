<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Routes;

use Arcanesoft\Blog\Http\Controllers\DashboardController;

/**
 * Class     DashboardRoutes
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardRoutes extends AbstractRouteRegistrar
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
        // admin::blog.index
        $this->get('/', [DashboardController::class, 'index'])
             ->name('index');
    }
}
