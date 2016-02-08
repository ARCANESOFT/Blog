<?php namespace Arcanesoft\Blog\Bases;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class     ModelObserver
 *
 * @package  Arcanedev\LaravelAuth\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class ModelObserver
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
     * ModelObserver constructor.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $event
     */
    public function __construct(Dispatcher $event)
    {
        $this->event = $event;
    }
}
