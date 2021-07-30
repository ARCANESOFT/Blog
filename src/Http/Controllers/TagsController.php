<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Controllers;

use Arcanesoft\Blog\Http\Datatables\TagsDatatable;
use Arcanesoft\Blog\Http\Requests\Tags\{CreateTagRequest, UpdateTagRequest};
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\Policies\TagsPolicy;
use Arcanesoft\Blog\Repositories\TagsRepository;
use Arcanesoft\Foundation\Support\Traits\HasNotifications;

/**
 * Class     TagsController
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsController extends Controller
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

        $this->setCurrentSidebarItem('blog::main.tags');
        $this->addBreadcrumbRoute(__('Tags'), 'admin::blog.tags.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(TagsPolicy::ability('index'));

        return $this->view('tags.index');
    }

    public function datatable(TagsDatatable $datatable)
    {
        $this->authorize(TagsPolicy::ability('index'));

        return $datatable;
    }

    public function metrics()
    {
        $this->authorize(TagsPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::blog.tags.metrics');

        $this->selectMetrics('arcanesoft.blog.metrics.tags');

        return $this->view('tags.metrics');
    }

    public function create()
    {
        $this->authorize(TagsPolicy::ability('create'));

        $this->addBreadcrumb(__('New Tag'));

        return $this->view('tags.create');
    }

    public function store(CreateTagRequest $request, TagsRepository $repo)
    {
        $this->authorize(TagsPolicy::ability('create'));

        $tag = $repo->createOne($request->validated());

        $this->notifySuccess(
            __('Tag Created'),
            __('A new tag has been successfully created!')
        );

        return redirect()->route('admin::blog.tags.show', [$tag]);
    }

    public function show(Tag $tag)
    {
        $this->authorize(TagsPolicy::ability('show'));

        $this->addBreadcrumbRoute(__("Tag's details"), 'admin::blog.tags.show', [$tag]);

        return $this->view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize(TagsPolicy::ability('update'), [$tag]);

        $this->addBreadcrumbRoute(__('Edit Tag'), 'admin::blog.tags.edit', [$tag]);

        return $this->view('tags.edit', compact('tag'));
    }

    public function update(Tag $tag, UpdateTagRequest $request, TagsRepository $repo)
    {
        $this->authorize(TagsPolicy::ability('update'), [$tag]);

        $repo->updateOne($tag, $request->validated());

        $this->notifySuccess(
            __('Tag Updated'),
            __('The tag has been successfully updated!')
        );

        return redirect()->route('admin::blog.tags.show', [$tag]);
    }

    public function delete(Tag $tag, TagsRepository $repo)
    {
        $this->authorize(TagsPolicy::ability('delete'), [$tag]);

        $repo->deleteOne($tag);

        $this->notifySuccess(
            __('Tag Deleted'),
            __('The tag has been successfully deleted!')
        );

        return $this->jsonResponseSuccess();
    }
}
