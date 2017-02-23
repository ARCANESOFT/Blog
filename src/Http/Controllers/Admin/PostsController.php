<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanesoft\Blog\Http\Requests\Admin\Posts\CreatePostRequest;
use Arcanesoft\Blog\Http\Requests\Admin\Posts\UpdatePostRequest;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\Policies\PostsPolicy;
use Illuminate\Support\Facades\Log;

/**
 * Class     PostsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The post model.
     *
     * @var \Arcanesoft\Blog\Models\Post
     */
    private $post;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
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
        $this->addBreadcrumbRoute('Posts', 'admin::blog.posts.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        $this->authorize(PostsPolicy::PERMISSION_LIST);

        $posts = $this->post->with(['author', 'category']);
        $posts = $trashed
            ? $posts->onlyTrashed()->paginate(30)
            : $posts->paginate(30);

        $this->setTitle($title = 'List of posts' . ($trashed ? ' - Trashed' : ''));
        $this->addBreadcrumb($title);

        return $this->view('admin.posts.list', compact('trashed', 'posts'));
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
        $this->authorize(PostsPolicy::PERMISSION_CREATE);

        $this->setTitle('Blog - Posts');
        $this->addBreadcrumb('Create post');

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = Post::getStatuses();

        return $this->view('admin.posts.create', compact('categories', 'tags', 'statuses'));
    }

    /**
     * Store the post.
     *
     * @param  \Arcanesoft\Blog\Http\Requests\Admin\Posts\CreatePostRequest  $request
     * @param  \Arcanesoft\Blog\Models\Post                                    $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePostRequest $request, Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_CREATE);

        $post->createOne($request->all());

        $message = "The post {$post->title} was created successfully !";
        Log::info($message, $post->toArray());
        $this->notifySuccess($message, 'Post created !');

        return redirect()->route('admin::blog.posts.index');
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
        $this->authorize(PostsPolicy::PERMISSION_SHOW);

        $post = $post->load(['author', 'category', 'tags']);

        $this->setTitle('Blog - Posts');
        $this->addBreadcrumb("Post - {$post->title}");

        return $this->view('admin.posts.show', compact('post'));
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
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        $this->setTitle('Blog - Posts');
        $this->addBreadcrumb('Edit post');

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = Post::getStatuses();

        return $this->view('admin.posts.edit', compact('post', 'categories', 'tags', 'statuses'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        $post->updateOne($request->all());

        $message = "The post {$post->title} was updated successfully !";
        Log::info($message, $post->toArray());
        $this->notifySuccess($message, 'Post updated !');

        return redirect()->route('admin::blog.posts.show', [$post->id]);
    }

    public function publish(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        // TODO: Complete the implementation
    }

    public function restore(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        // TODO: Complete the implementation
    }

    public function delete(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_DELETE);

        // TODO: Complete the implementation
    }
}
