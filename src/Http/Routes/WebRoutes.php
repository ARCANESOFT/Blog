<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Routes;

/**
 * Class     BlogRoutes
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class WebRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /** {@inheritDoc} */
    public function map(): void
    {
        $this->adminGroup(function () {
            static::mapRouteClasses([
                DashboardRoutes::class,
                AuthorsRoutes::class,
                PostsRoutes::class,
                TagsRoutes::class,
            ]);
        });
    }

    /** {@inheritDoc} */
    public function bindings(): void
    {
        static::bindRouteClasses([
            DashboardRoutes::class,
            AuthorsRoutes::class,
            PostsRoutes::class,
            TagsRoutes::class,
        ]);
    }
}
