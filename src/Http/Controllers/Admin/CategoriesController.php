<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanesoft\Blog\Http\Requests\Admin\Categories\CreateCategoryRequest;
use Arcanesoft\Blog\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Policies\CategoriesPolicy;
use Illuminate\Support\Facades\Log;

/**
 * Class     CategoriesController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesController extends Controller
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The category model.
     *
     * @var \Arcanesoft\Blog\Models\Category
     */
    private $category;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
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
        $this->addBreadcrumbRoute('Categories', 'admin::blog.categories.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index($trashed = false)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_LIST);

        $categories = $this->category->with(['posts']);
        $categories = $trashed
            ? $categories->onlyTrashed()->paginate(30)
            : $categories->paginate(30);

        $this->setTitle($title = 'Blog - Categories');
        $this->addBreadcrumb('List all categories');

        return $this->view('admin.categories.list', compact('categories', 'trashed'));
    }

    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize(CategoriesPolicy::PERMISSION_CREATE);

        $this->setTitle('Blog - Categories');
        $this->addBreadcrumb('Create category');

        return $this->view('admin.categories.create');
    }

    public function store(CreateCategoryRequest $request, Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_CREATE);

        $category->fill($request->only(['name']));
        $category->save();

        $message = "The category {$category->name} was created successfully !";
        Log::info($message, $category->toArray());
        $this->notifySuccess($message, 'Category created !');

        return redirect()->route('admin::blog.categories.index');
    }

    public function show(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_SHOW);

        $category->load(['posts']);

        $this->setTitle('Blog - Categories');
        $this->addBreadcrumb("Category - {$category->name}");

        return $this->view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        $this->setTitle('Blog - Categories');
        $this->addBreadcrumb('Update category');

        return $this->view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        $category->update($request->only(['name']));

        $message = "The category {$category->name} was updated successfully !";
        Log::info($message, $category->toArray());
        $this->notifySuccess($message, 'Category updated !');

        return redirect()->route('admin::blog.categories.show', [$category]);
    }

    public function restore(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        self::onlyAjax();

        try {
            $category->restore();

            $message = "The category {$category->name} has been successfully restored !";
            Log::info($message, $category->toArray());
            $this->notifySuccess($message, 'Category restored !');

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

    public function delete(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_DELETE);

        self::onlyAjax();

        try {
            $category->trashed()
                ? $category->forceDelete()
                : $category->delete();

            $message = "The category {$category->name} has been successfully deleted !";
            Log::info($message, $category->toArray());
            $this->notifySuccess($message, 'Category deleted !');

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
