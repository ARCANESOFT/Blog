<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Datatables;

use Arcanesoft\Foundation\Datatable\Concerns\HasActions;
use Arcanesoft\Foundation\Datatable\Concerns\HasPagination;
use Arcanesoft\Foundation\Datatable\Datatable as BaseDatatable;

/**
 * Class     Datatable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Datatable extends BaseDatatable
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasActions;
    use HasPagination;
}
