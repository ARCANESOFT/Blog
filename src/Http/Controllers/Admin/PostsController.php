<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
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
     |  Traits
     | -----------------------------------------------------------------
     */

    use JsonResponses;

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
     * PostsController constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     */
    public function __construct(Post $post)
    {
        parent::__construct();

        $this->post = $post;

        $this->setCurrentPage('blog-posts');
        $this->addBreadcrumbRoute(trans('blog::posts.titles.posts'), 'admin::blog.posts.index');
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

        $title = trans('blog::posts.titles.posts-list');
        $this->setTitle($title . ($trashed ? ' - '.trans('core::generals.trashed') : ''));
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

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = Post::getStatuses();

        $this->setTitle($title = trans('blog::posts.titles.create-post'));
        $this->addBreadcrumb($title);

        return $this->view('admin.posts.create', compact('categories', 'tags', 'statuses'));
    }

    /**
     * Store the post.
     *
     * @param  \Arcanesoft\Blog\Http\Requests\Admin\Posts\CreatePostRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePostRequest $request)
    {
        $this->authorize(PostsPolicy::PERMISSION_CREATE);

        $post = Post::createOne($request->getValidatedData());

        $this->transNotification('created', ['title' => $post->title], $post->toArray());

        return redirect()->route('admin::blog.posts.show', [$post]);
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

        $post = $post->load(['author', 'category', 'tags', 'seo']);

        $this->setTitle(trans('blog::posts.titles.post-details'));
        $this->addBreadcrumb($post->title);

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

        $this->setTitle($title = trans('blog::posts.titles.edit-post'));
        $this->addBreadcrumb($title);

        $categories = Category::getSelectOptions();
        $tags       = Tag::getSelectOptions();
        $statuses   = Post::getStatuses();

        return $this->view('admin.posts.edit', compact('post', 'categories', 'tags', 'statuses'));
    }

    /**
     * Update the post.
     *
     * @param  \Arcanesoft\Blog\Models\Post                                  $post
     * @param  \Arcanesoft\Blog\Http\Requests\Admin\Posts\UpdatePostRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        $post->updateOne($request->getValidatedData());

        $this->transNotification('updated', ['title' => $post->title], $post->toArray());

        return redirect()->route('admin::blog.posts.show', [$post]);
    }

    /**
     * Publish/Unpublish a post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        // TODO: Complete the implementation
    }

    /**
     * Restore a trashed post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_UPDATE);

        try {
            $post->restore();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('restored', ['title' => $post->title], $post->toArray())
            ]);
        }
        catch (\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Post $post)
    {
        $this->authorize(PostsPolicy::PERMISSION_DELETE);

        try {
            $post->trashed() ? $post->forceDelete() : $post->delete();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('deleted', ['title' => $post->title], $post->toArray())
            ]);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Notify with translation.
     *
     * @param  string  $action
     * @param  array   $replace
     * @param  array   $context
     *
     * @return string
     */
    protected function transNotification($action, array $replace = [], array $context = [])
    {
        $title   = trans("blog::posts.messages.{$action}.title");
        $message = trans("blog::posts.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
