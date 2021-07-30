<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Controllers;

use Arcanesoft\Blog\Http\Datatables\PostsDatatable;
use Arcanesoft\Blog\Http\Requests\Posts\{CreatePostRequest, UpdatePostRequest};
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Policies\PostsPolicy;
use Arcanesoft\Blog\Repositories\{PostsRepository, TagsRepository};
use Arcanesoft\Foundation\Support\Traits\HasNotifications;

/**
 * Class     PostsController
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasNotifications;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    public function __construct()
    {
        parent::__construct();

        $this->setCurrentSidebarItem('blog::main.posts');
        $this->addBreadcrumbRoute(__('Posts'), 'admin::blog.posts.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(PostsPolicy::ability('index'));

        return $this->view('posts.index');
    }

    public function datatable(PostsDatatable $datatable)
    {
        $this->authorize(PostsPolicy::ability('index'));

        return $datatable;
    }

    public function metrics()
    {
        $this->authorize(PostsPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::blog.posts.metrics');

        $this->selectMetrics('arcanesoft.blog.metrics.posts');

        return $this->view('posts.metrics');
    }

    public function create(TagsRepository $repo)
    {
        $this->authorize(PostsPolicy::ability('create'));

        $this->addBreadcrumb(__('New Post'));

        return $this->view('posts.create', [
            'tags' => $repo->getSelectData(false),
        ]);
    }

    public function store(CreatePostRequest $request, PostsRepository $postsRepository)
    {
        $this->authorize(PostsPolicy::ability('create'));

        $post = $postsRepository->createOne($request->validated());

        $this->notifySuccess(
            __('Post Created'),
            __('A new post has been successfully created!')
        );

        return redirect()->route('admin::blog.posts.show', [$post]);
    }

    public function show(Post $post)
    {
        $this->authorize(PostsPolicy::ability('show'));

        $this->addBreadcrumbRoute(__("Post's details"), 'admin::blog.posts.show', [$post]);

        return $this->view('posts.show', compact('post'));
    }

    public function edit(Post $post, TagsRepository $tagsRepository)
    {
        $this->authorize(PostsPolicy::ability('update'), [$post]);

        $tags = $tagsRepository->getSelectData();

        $this->addBreadcrumbRoute(__('Edit Post'), 'admin::blog.posts.edit', [$post]);

        return $this->view('posts.edit', compact('posts', 'tags'));
    }

    public function update(Post $post, UpdatePostRequest $request, PostsRepository $postRepository)
    {
        $this->authorize(PostsPolicy::ability('update'), [$post]);

        $postRepository->updateOne($post, $request->getValidatedData());

        $this->notifySuccess(
            __('Post Updated'),
            __('The post has been successfully updated!')
        );

        return redirect()->route('admin::blog.posts.show', [$post]);
    }

    public function delete(Post $post, PostsRepository $postRepository)
    {
        $this->authorize(PostsPolicy::ability('delete'), [$post]);

        $postRepository->deleteOne($post);

        $this->notifySuccess(
            __('Post Deleted'),
            __('The post has been successfully deleted!')
        );

        return $this->jsonResponseSuccess();
    }
}
