<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanesoft\Auth\Policies\DashboardPolicy;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends Controller
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('blog-dashboard');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(DashboardPolicy::PERMISSION_STATS);

        $this->setTitle($title = 'Blog - Dashboard');
        $this->addBreadcrumb('Statistics');

        return $this->view('admin.dashboard');
    }
}
