<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Controllers;

use Arcanesoft\Blog\Http\Datatables\AuthorsDatatable;
use Arcanesoft\Foundation\Support\Traits\HasNotifications;
use Arcanesoft\Blog\Http\Requests\Authors\{CreateAuthorRequest, UpdateAuthorRequest};
use Arcanesoft\Blog\Models\Author;
use Arcanesoft\Blog\Policies\AuthorsPolicy;
use Arcanesoft\Blog\Repositories\AuthorsRepository;

/**
 * Class     AuthorsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorsController extends Controller
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

        $this->setCurrentSidebarItem('blog::main.authors');
        $this->addBreadcrumbRoute(__('Authors'), 'admin::blog.authors.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(AuthorsPolicy::ability('index'));

        $this->selectMetrics('arcanesoft.blog.metrics.authors');

        return $this->view('authors.index');
    }

    public function datatable(AuthorsDatatable $datatable)
    {
        $this->authorize(AuthorsPolicy::ability('index'));

        return $datatable;
    }

    public function metrics()
    {
        $this->authorize(AuthorsPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::blog.authors.metrics');

        return $this->view('authors.metrics');
    }

    public function create()
    {
        $this->authorize(AuthorsPolicy::ability('create'));

        return $this->view('authors.create');
    }

    public function store(CreateAuthorRequest $request, AuthorsRepository $repo)
    {
        $this->authorize(AuthorsPolicy::ability('create'));

        $author = $repo->createOne($request->getValidatedData());

        $this->notifySuccess(
            __('Author Created'),
            __('The author has been successfully created!')
        );

        return redirect()->route('admin::blog.authors.show', [$author]);
    }

    public function show(Author $author)
    {
        $this->authorize(AuthorsPolicy::ability('show'));

        $this->addBreadcrumbRoute(__("Author's details"), 'admin::blog.authors.show', [$author]);

        return $this->view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        $this->authorize(AuthorsPolicy::ability('update'));

        $this->addBreadcrumbRoute(__('Edit Author'), 'admin::blog.authors.edit', [$author]);

        return $this->view('authors.edit', compact('author'));
    }

    public function update(Author $author, UpdateAuthorRequest $request, AuthorsRepository $repo)
    {
        $this->authorize(AuthorsPolicy::ability('update'));

        $repo->updateOne($author, $request->getValidatedData());

        $this->notifySuccess(
            __('Author Updated'),
            __('The author has been successfully updated!')
        );

        return redirect()->route('admin::blog.authors.show', [$author]);
    }

    public function delete(Author $author, AuthorsRepository $repo)
    {
        $this->authorize(AuthorsPolicy::ability('delete'));

        $repo->deleteOne($author);

        $this->notifySuccess(
            __('Author Deleted'),
            __('The author has been successfully deleted!')
        );

        return $this->jsonResponseSuccess();
    }
}
