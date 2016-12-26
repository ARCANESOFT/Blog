<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('blog-dashboard');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize('blog.dashboard.stats');

        $this->setTitle($title = 'Blog - Dashboard');
        $this->addBreadcrumb('Statistics');

        return $this->view('admin.dashboard');
    }
}
