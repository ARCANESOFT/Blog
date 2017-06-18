<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Blog\Http\Requests\Admin\Tags\CreateTagRequest;
use Arcanesoft\Blog\Http\Requests\Admin\Tags\UpdateTagRequest;
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\Policies\TagsPolicy;
use Illuminate\Support\Facades\Log;

/**
 * Class     TagsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsController extends Controller
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

    /** @var  \Arcanesoft\Blog\Models\Tag */
    private $tag;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * TagsController constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     */
    public function __construct(Tag $tag)
    {
        parent::__construct();

        $this->tag = $tag;

        $this->setCurrentPage('blog-tags');
        $this->addBreadcrumbRoute(trans('blog::tags.titles.tags'), 'admin::blog.tags.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index($trashed = false)
    {
        $this->authorize(TagsPolicy::PERMISSION_LIST);

        $tags = $this->tag->with(['posts']);
        $tags = $trashed
            ? $tags->onlyTrashed()->paginate(30)
            : $tags->paginate(30);

        $this->setTitle($title = trans('blog::tags.titles.tags-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.tags.list', compact('tags', 'trashed'));
    }

    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize(TagsPolicy::PERMISSION_CREATE);

        $this->setTitle($title = trans('blog::tags.titles.create-tag'));
        $this->addBreadcrumb($title);

        return $this->view('admin.tags.create');
    }

    public function store(CreateTagRequest $request)
    {
        $this->authorize(TagsPolicy::PERMISSION_CREATE);

        $tag = Tag::createOne($request->getValidatedData());

        $this->transNotification('created', ['name' => $tag->name], $tag->toArray());

        return redirect()->route('admin::blog.tags.index');
    }

    public function show(Tag $tag)
    {
        $this->authorize(TagsPolicy::PERMISSION_SHOW);

        $tag->load(['posts']);

        $this->setTitle(trans('blog::tags.titles.tag-details'));
        $this->addBreadcrumb($tag->name);

        return $this->view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize(TagsPolicy::PERMISSION_UPDATE);

        $this->setTitle($title = trans('blog::tags.titles.edit-tag'));
        $this->addBreadcrumb($title);

        return $this->view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize(TagsPolicy::PERMISSION_UPDATE);

        $tag->updateOne($request->getValidatedData());

        $this->transNotification('updated', ['name' => $tag->name], $tag->toArray());

        return redirect()->route('admin::blog.tags.show', [$tag]);
    }

    public function restore(Tag $tag)
    {
        $this->authorize(TagsPolicy::PERMISSION_UPDATE);

        try {
            $tag->restore();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('restored', ['name' => $tag->name], $tag->toArray())
            ]);
        }
        catch (\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    public function delete(Tag $tag)
    {
        $this->authorize(TagsPolicy::PERMISSION_DELETE);

        try {
            $tag->trashed() ? $tag->forceDelete() : $tag->delete();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('deleted', ['name' => $tag->name], $tag->toArray())
            ]);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
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
        $title   = trans("blog::tags.messages.{$action}.title");
        $message = trans("blog::tags.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
