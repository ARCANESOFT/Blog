<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Controllers;

use Arcanesoft\Foundation\Support\Http\Controller as BaseController;

/**
 * Class     Controller
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends BaseController
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The view namespace.
     *
     * @var string|null
     */
    protected $viewNamespace = 'blog';

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addBreadcrumbRoute(__('Blog'), 'admin::blog.index');
    }
}
