<?php namespace Arcanesoft\Blog\Http\Controllers\Foundation;

use Arcanesoft\Blog\Bases\FoundationController;
use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Http\Requests\Backend\Posts\CreatePostRequest;
use Arcanesoft\Blog\Http\Requests\Backend\Posts\UpdatePostRequest;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Support\Facades\Log;

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

        $posts = $this->post->with(['author', 'category']);
        $posts = $trashed
            ? $posts->onlyTrashed()->paginate(30)
            : $posts->paginate(30);

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

    /**
     * Create a post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('blog.posts.create');

        $title = 'Blog - Posts';
        $this->setTitle($title);
        $this->addBreadcrumb('Create post');

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = PostStatus::all();

        return $this->view('foundation.posts.create', compact('categories', 'tags', 'statuses'));
    }

    /**
     * Store the post.
     *
     * @param  \Arcanesoft\Blog\Http\Requests\Backend\Posts\CreatePostRequest  $request
     * @param  \Arcanesoft\Blog\Models\Post                                    $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePostRequest $request, Post $post)
    {
        $this->authorize('blog.posts.create');

        $post->createOne($request->all());

        $message = "The post {$post->title} was created successfully !";
        Log::info($message, $post->toArray());
        $this->notifySuccess($message, 'Post created !');

        return redirect()->route('blog::foundation.posts.index');
    }

    /**
     * Show a post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        $this->authorize('blog.posts.show');

        $post = $post->load(['author', 'category', 'tags']);

        $title = 'Blog - Posts';
        $this->setTitle($title);
        $this->addBreadcrumb('Post - ' . $post->title);

        return $this->view('foundation.posts.show', compact('post'));
    }

    /**
     * Edit a post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $this->authorize('blog.posts.update');

        $title = 'Blog - Posts';
        $this->setTitle($title);
        $this->addBreadcrumb('Edit post');

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = PostStatus::all();

        return $this->view('foundation.posts.edit', compact('post', 'categories', 'tags', 'statuses'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('blog.posts.update');

        $post->updateOne($request->all());

        $message = "The post {$post->title} was updated successfully !";
        Log::info($message, $post->toArray());
        $this->notifySuccess($message, 'Post updated !');

        return redirect()->route('blog::foundation.posts.show', [$post->id]);
    }

    public function publish(Post $post)
    {
        $this->authorize('blog.posts.update');
    }

    public function restore(Post $post)
    {
        $this->authorize('blog.posts.update');
    }

    public function delete(Post $post)
    {
        $this->authorize('blog.posts.delete');
    }
}
