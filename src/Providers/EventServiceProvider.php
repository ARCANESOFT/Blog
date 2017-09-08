<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class     EventServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EventServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the application's event listeners.
     */
    public function boot()
    {
        $this->listen = array_filter(config('arcanesoft.blog.events.listeners'));

        parent::boot();
    }
}
