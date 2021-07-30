<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class     EventServiceProvider
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EventServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens(): array
    {
        return config()->get('arcanesoft.blog.events', []);
    }
}
