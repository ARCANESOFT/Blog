<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Views\Components;

use Arcanesoft\Blog\Policies\PostsPolicy;
use Arcanesoft\Blog\Repositories\PostsRepository;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class     PostsDatatable
 *
 * @package  Arcanesoft\Blog\Views\Components
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsDatatable extends Datatable
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const NAME = 'blog::posts.index';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    public $sortField = 'title';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check the authorization.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $guard
     *
     * @return bool
     */
    public function authorize(Gate $guard): bool
    {
        return $guard->allows(PostsPolicy::ability('index'));
    }

    /**
     * Render the component.
     *
     * @param  \Arcanesoft\Blog\Repositories\PostsRepository  $repo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(PostsRepository $repo)
    {
        return view('blog::posts._datatables.index', [
            'posts'  => $this->getResults($repo),
            'fields' => $this->getFields(),
        ]);
    }

    /**
     * Get the results.
     *
     * @param  \Arcanesoft\Blog\Repositories\PostsRepository  $repo
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getResults(PostsRepository $repo): LengthAwarePaginator
    {
        $results = $repo->all();

        return $this->convertToPagination($results);
    }

    /**
     * Get the fields
     *
     * @return array
     */
    private function getFields(): array
    {
        return [
            'title'      => $this->renderSortField('title', 'Title'),
            'created_at' => $this->renderSortField('created', 'Created at'),
            'published'  => __('Published'),
            'actions'    => __('Actions'),
        ];
    }
}
