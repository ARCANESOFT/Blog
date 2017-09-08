<?php namespace Arcanesoft\Blog\Events\Posts;

/**
 * Class     AbstractPostEvent
 *
 * @package  Arcanesoft\Blog\Events\Posts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractPostEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Blog\Models\Post */
    public $post;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AbstractPostEvent constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }
}
