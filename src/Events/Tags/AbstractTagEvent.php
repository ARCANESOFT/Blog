<?php namespace Arcanesoft\Blog\Events\Tags;

/**
 * Class     AbstractTagEvent
 *
 * @package  Arcanesoft\Blog\Events\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractTagEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Blog\Models\Tag */
    public $tag;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AbstractTagEvent constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }
}
