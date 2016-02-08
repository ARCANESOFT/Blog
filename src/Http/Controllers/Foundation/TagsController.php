<?php namespace Arcanesoft\Blog\Http\Controllers\Foundation;

use Arcanesoft\Blog\Bases\FoundationController;
use Arcanesoft\Blog\Http\Requests\Backend\Tags\CreateTagRequest;
use Arcanesoft\Blog\Http\Requests\Backend\Tags\UpdateTagRequest;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Support\Facades\Log;

/**
 * Class     TagsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsController extends FoundationController
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
        $this->addBreadcrumbRoute('Tags', 'blog::foundation.tags.index');
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

        $title = 'Blog - Tags';
        $this->setTitle($title);
        $this->addBreadcrumb('List all tags');

        return $this->view('foundation.tags.list', compact('tags', 'trashed'));
    }
    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize('blog.tags.create');

        $title = 'Blog - Tags';
        $this->setTitle($title);
        $this->addBreadcrumb('Create tag');

        return $this->view('foundation.tags.create');
    }

    public function store(CreateTagRequest $request, Tag $tag)
    {
        $this->authorize('blog.tags.create');

        $tag->fill($request->only(['name']));
        $tag->save();

        $message = "The tag {$tag->name} was created successfully !";
        Log::info($message, $tag->toArray());
        $this->notifySuccess($message, 'Tag created !');

        return redirect()->route('blog::foundation.tags.index');
    }

    public function show(Tag $tag)
    {
        $this->authorize('blog.tags.show');

        $tag->load(['posts']);

        $title = 'Blog - Tags';
        $this->setTitle($title);
        $this->addBreadcrumb('Tag - ' . $tag->name);

        return $this->view('foundation.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize('blog.tags.update');

        $title = 'Blog - Tags';
        $this->setTitle($title);
        $this->addBreadcrumb('Update tag');

        return $this->view('foundation.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('blog.tags.update');

        $tag->update($request->only(['name']));

        $message = "The tag {$tag->name} was updated successfully !";
        Log::info($message, $tag->toArray());
        $this->notifySuccess($message, 'Tag updated !');

        return redirect()->route('blog::foundation.tags.show', [$tag->id]);
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

            $ajax = [
                'status'  => 'success',
                'message' => $message,
            ];
        }
        catch (\Exception $e) {
            $ajax = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($ajax);
    }

    public function delete(Tag $tag)
    {
        self::onlyAjax();
        $this->authorize('blog.tags.delete');

        try {
            if ($tag->trashed())
                $tag->forceDelete();
            else
                $tag->delete();

            $message = "The tag {$tag->name} has been successfully deleted !";
            Log::info($message, $tag->toArray());
            $this->notifySuccess($message, 'Tag deleted !');

            $ajax = [
                'status'  => 'success',
                'message' => $message,
            ];
        }
        catch(\Exception $e) {
            $ajax = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($ajax);
    }
}
