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

        $this->registerBreadcrumbs('public');
        $this->addBreadcrumbRoute('Blog', 'public::blog.posts.index');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Do random stuff before rendering view.
     */
    protected function beforeViewRender()
    {
        $this->loadBreadcrumbs();
    }
}
