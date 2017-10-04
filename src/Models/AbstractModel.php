<?php namespace Arcanesoft\Blog\Models;

use Arcanedev\Support\Database\Model as BaseModel;

/**
 * Class     AbstractModel
 *
 * @package  Arcanesoft\Blog\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractModel extends BaseModel
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prefix = config('arcanesoft.blog.database.prefix', null);
    }
}
