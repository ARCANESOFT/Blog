<?php namespace Arcanesoft\Blog\Http\Controllers\Front;

use Arcanesoft\Core\Http\Controllers\Controller as BaseController;

/**
 * Class     Controller
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends BaseController
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Controller constructor.
     *
     * @todo: Refactor this constructor to the core
     */
    public function __construct()
    {
        parent::__construct();

        $this->registerBreadcrumbs('public');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Do random stuff before rendering view.
     */
    protected function beforeViewRender()
    {
        $this->loadBreadcrumbs();
    }
}
