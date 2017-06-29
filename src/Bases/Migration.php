<?php namespace Arcanesoft\Blog\Bases;

use Arcanedev\Support\Bases\Migration as BaseMigration;

/**
 * Class     Migration
 *
 * @package  Arcanesoft\Blog\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Migration extends BaseMigration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Make a migration instance.
     */
    public function __construct()
    {
        $this->setConnection(config('arcanesoft.blog.database.connection', null));
        $this->setPrefix(config('arcanesoft.blog.database.prefix', ''));
    }
}
