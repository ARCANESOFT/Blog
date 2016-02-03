<?php namespace Arcanesoft\Blog\Http\Controllers\Foundation;

use Arcanesoft\Blog\Bases\FoundationController;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends FoundationController
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

        $title = 'Blog - Dashboard';
        $this->setTitle($title);
        $this->addBreadcrumb('Statistics');

        return $this->view('foundation.dashboard');
    }
}
