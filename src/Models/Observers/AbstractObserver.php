<?php namespace Arcanesoft\Blog\Models\Observers;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class     AbstractObserver
 *
 * @package  Arcanesoft\Blog\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractObserver
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $event;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * AbstractObserver constructor.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $event
     */
    public function __construct(Dispatcher $event)
    {
        $this->event = $event;
    }
}
