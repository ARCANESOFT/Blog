<?php namespace Arcanesoft\Blog\Bases;

use Arcanesoft\Core\Bases\FoundationController as BaseController;
use Arcanesoft\Core\Traits\Notifyable;

/**
 * Class     FoundationController
 *
 * @package  Arcanesoft\Blog\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FoundationController extends BaseController
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Notifyable;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The view namespace.
     *
     * @var string
     */
    protected $viewNamespace = 'blog';

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

        $this->addBreadcrumbRoute('Blog', 'blog::foundation.dashboard');
    }
}
