<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Controllers;

/**
 * Class     DashboardController
 *
 * @package  Arcanesoft\Blog\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->setCurrentSidebarItem('blog::main');
        $this->addBreadcrumb(__('Statistics'));

        return $this->view('dashboard');
    }
}
