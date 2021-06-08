<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Database;

use Arcanedev\Support\Database\Migration as BaseMigration;

/**
 * Class     Migration
 *
 * @package  Arcanesoft\Blog\Base
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Migration extends BaseMigration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->setConnection(config('arcanesoft.blog.database.connection'));
        $this->setPrefix(config('arcanesoft.blog.database.prefix'));
    }
}
