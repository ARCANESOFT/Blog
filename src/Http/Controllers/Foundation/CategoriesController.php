<?php namespace Arcanesoft\Blog\Http\Controllers\Foundation;

use Arcanesoft\Blog\Bases\FoundationController;
use Arcanesoft\Blog\Http\Requests\Backend\Categories\CreateCategoryRequest;
use Arcanesoft\Blog\Http\Requests\Backend\Categories\UpdateCategoryRequest;
use Arcanesoft\Blog\Models\Category;
use Illuminate\Support\Facades\Log;

/**
 * Class     CategoriesController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The category model.
     *
     * @var \Arcanesoft\Blog\Models\Category
     */
    private $category;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Blog\Models\Category  $category
     */
    public function __construct(Category $category)
    {
        parent::__construct();

        $this->category = $category;

        $this->setCurrentPage('blog-categories');
        $this->addBreadcrumbRoute('Categories', 'blog::foundation.categories.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index($trashed = false)
    {
        $this->authorize('blog.categories.list');

        $categories = $this->category->with(['posts']);
        $categories = $trashed
            ? $categories->onlyTrashed()->paginate(30)
            : $categories->paginate(30);

        $title = 'Blog - Categories';
        $this->setTitle($title);
        $this->addBreadcrumb('List all categories');

        return $this->view('foundation.categories.list', compact('categories', 'trashed'));
    }

    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize('blog.categories.create');

        $title = 'Blog - Categories';
        $this->setTitle($title);
        $this->addBreadcrumb('Create category');

        return $this->view('foundation.categories.create');
    }

    public function store(CreateCategoryRequest $request, Category $category)
    {
        $this->authorize('blog.categories.create');

        $category->fill($request->only(['name']));
        $category->save();

        $message = "The category {$category->name} was created successfully !";
        Log::info($message, $category->toArray());
        $this->notifySuccess($message, 'Category created !');

        return redirect()->route('blog::foundation.categories.index');
    }

    public function show(Category $category)
    {
        $this->authorize('blog.categories.show');

        $category->load(['posts']);

        $title = 'Blog - Categories';
        $this->setTitle($title);
        $this->addBreadcrumb('Category - ' . $category->name);

        return $this->view('foundation.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorize('blog.categories.update');

        $title = 'Blog - Categories';
        $this->setTitle($title);
        $this->addBreadcrumb('Update category');

        return $this->view('foundation.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('blog.categories.update');

        $category->update($request->only(['name']));

        $message = "The category {$category->name} was updated successfully !";
        Log::info($message, $category->toArray());
        $this->notifySuccess($message, 'Category updated !');

        return redirect()->route('blog::foundation.categories.show', [$category->id]);
    }

    public function restore(Category $category)
    {
        $this->authorize('blog.categories.update');
    }

    public function delete(Category $category)
    {
        $this->authorize('blog.categories.delete');
    }
}
