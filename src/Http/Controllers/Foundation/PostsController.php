<?php namespace Arcanesoft\Blog\Http\Controllers\Foundation;

use Arcanesoft\Blog\Bases\FoundationController;
use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The post model.
     *
     * @var \Arcanesoft\Blog\Models\Post
     */
    private $post;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct();

        $this->post = $post;

        $this->setCurrentPage('blog-posts');
        $this->addBreadcrumbRoute('Posts', 'blog::foundation.posts.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * List the posts.
     *
     * @param  bool  $trashed
     *
     * @return \Illuminate\View\View
     */
    public function index($trashed = false)
    {
        $this->authorize('blog.posts.list');

        $posts = $trashed
            ? $this->post->onlyTrashed()->paginate(30)
            : $this->post->paginate(30);

        $title = 'List of posts' . ($trashed ? ' - Trashed' : '');
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.posts.list', compact('trashed', 'posts'));
    }

    /**
     * List the trashed posts.
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        //
    }

    public function store()
    {
        //
    }

    public function show($post)
    {
        //
    }

    public function edit($post)
    {
        //
    }

    public function update($post)
    {
        //
    }

    public function publish($post)
    {
        //
    }

    public function restore($post)
    {
        //
    }

    public function delete($post)
    {
        //
    }
}
