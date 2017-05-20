<?php namespace Arcanesoft\Blog\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
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
     |  Traits
     | -----------------------------------------------------------------
     */

    use JsonResponses;

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
     * CategoriesController constructor.
     *
     * @param  \Arcanesoft\Blog\Models\Category  $category
     */
    public function __construct(Category $category)
    {
        parent::__construct();

        $this->category = $category;

        $this->setCurrentPage('blog-categories');
        $this->addBreadcrumbRoute(trans('blog::categories.titles.categories'), 'admin::blog.categories.index');
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

        $this->setTitle($title = trans('blog::categories.titles.categories-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.categories.list', compact('categories', 'trashed'));
    }

    public function trash()
    {
        return $this->index(true);
    }

    public function create()
    {
        $this->authorize(CategoriesPolicy::PERMISSION_CREATE);

        $this->setTitle($title = trans('blog::categories.titles.create-category'));
        $this->addBreadcrumb($title);

        return $this->view('admin.categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_CREATE);

        $category = Category::createOne($request->getValidatedData());

        $this->transNotification('created', ['name' => $category->name], $category->toArray());

        return redirect()->route('admin::blog.categories.index');
    }

    public function show(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_SHOW);

        $category->load(['posts']);

        $this->setTitle($title = trans('blog::categories.titles.category-details'));
        $this->addBreadcrumb($category->name);

        return $this->view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        $this->setTitle($title = trans('blog::categories.titles.edit-category'));
        $this->addBreadcrumb($title);

        return $this->view('admin.categories.edit', compact('category'));
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        $category->update($request->getValidatedData());

        $this->transNotification('updated', ['name' => $category->name], $category->toArray());

        return redirect()->route('admin::blog.categories.show', [$category]);
    }

    public function delete(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_DELETE);

        try {
            $category->trashed() ? $category->forceDelete() : $category->delete();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('deleted', ['name' => $category->name], $category->toArray())
            ]);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    public function restore(Category $category)
    {
        $this->authorize(CategoriesPolicy::PERMISSION_UPDATE);

        try {
            $category->restore();

            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('restored', ['name' => $category->name], $category->toArray())
            ]);
        }
        catch (\Exception $e) {
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
        $title   = trans("blog::categories.messages.{$action}.title");
        $message = trans("blog::categories.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
