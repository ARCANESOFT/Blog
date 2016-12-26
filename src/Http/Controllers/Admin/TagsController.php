<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanesoft\Blog\Http\Requests\Admin\Tags\CreateTagRequest;
use Arcanesoft\Blog\Http\Requests\Admin\Tags\UpdateTagRequest;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Support\Facades\Log;

/**
 * Class     TagsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Arcanesoft\Blog\Models\Tag
     */
    private $tag;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     */
    public function __construct(Tag $tag)
    {
        parent::__construct();

        $this->tag = $tag;

        $this->setCurrentPage('blog-tags');
        $this->addBreadcrumbRoute('Tags', 'admin::blog.tags.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index($trashed = false)
    {
        $this->authorize('blog.tags.list');

        $tags = $this->tag->with(['posts']);
        $tags = $trashed
            ? $tags->onlyTrashed()->paginate(30)
            : $tags->paginate(30);

        $this->setTitle('Blog - Tags');
        $this->addBreadcrumb('List all tags');

        return $this->view('admin.tags.list', compact('tags', 'trashed'));
    }
    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize('blog.tags.create');

        $this->setTitle('Blog - Tags');
        $this->addBreadcrumb('Create tag');

        return $this->view('admin.tags.create');
    }

    public function store(CreateTagRequest $request, Tag $tag)
    {
        $this->authorize('blog.tags.create');

        $tag->fill($request->only(['name']));
        $tag->save();

        $message = "The tag {$tag->name} was created successfully !";
        Log::info($message, $tag->toArray());
        $this->notifySuccess($message, 'Tag created !');

        return redirect()->route('admin::blog.tags.index');
    }

    public function show(Tag $tag)
    {
        $this->authorize('blog.tags.show');

        $tag->load(['posts']);

        $this->setTitle('Blog - Tags');
        $this->addBreadcrumb("Tag - {$tag->name}");

        return $this->view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize('blog.tags.update');

        $this->setTitle('Blog - Tags');
        $this->addBreadcrumb('Update tag');

        return $this->view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('blog.tags.update');

        $tag->update($request->only(['name']));

        $message = "The tag {$tag->name} was updated successfully !";
        Log::info($message, $tag->toArray());
        $this->notifySuccess($message, 'Tag updated !');

        return redirect()->route('admin::blog.tags.show', [$tag]);
    }

    public function restore(Tag $tag)
    {
        self::onlyAjax();
        $this->authorize('blog.tags.update');

        try {
            $tag->restore();

            $message = "The tag {$tag->name} has been successfully restored !";
            Log::info($message, $tag->toArray());
            $this->notifySuccess($message, 'Tag restored !');

            return response()->json([
                'status'  => 'success',
                'message' => $message,
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Tag $tag)
    {
        self::onlyAjax();
        $this->authorize('blog.tags.delete');

        try {
            $tag->trashed()
                ? $tag->forceDelete()
                : $tag->delete();

            $message = "The tag {$tag->name} has been successfully deleted !";
            Log::info($message, $tag->toArray());
            $this->notifySuccess($message, 'Tag deleted !');

            return response()->json([
                'status'  => 'success',
                'message' => $message,
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
