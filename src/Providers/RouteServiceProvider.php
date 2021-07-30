<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Providers;

use Arcanesoft\Blog\Http\Routes;
use Arcanesoft\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the registered routes.
     *
     * @return array
     */
    public function routeClasses(): array
    {
        return [
            Routes\WebRoutes::class,
        ];
    }
}
