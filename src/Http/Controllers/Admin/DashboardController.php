<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanesoft\Blog\Policies\DashboardPolicy;

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
     * DashboardController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('blog-dashboard');
        $this->addBreadcrumbRoute(trans('blog::dashboard.titles.statistics'), 'admin::blog.dashboard');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize(DashboardPolicy::PERMISSION_STATS);

        $this->setTitle(trans('blog::dashboard.titles.statistics'));

        return $this->view('admin.dashboard');
    }
}
