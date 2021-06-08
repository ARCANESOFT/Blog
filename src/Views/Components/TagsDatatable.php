<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Views\Components;

use Arcanesoft\Blog\Policies\TagsPolicy;
use Arcanesoft\Blog\Repositories\TagsRepository;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class     TagsDatatable
 *
 * @package  Arcanesoft\Blog\Views\Components
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsDatatable extends Datatable
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const NAME = 'blog::tags.index';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    public $sortField = 'name';

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
        return $guard->allows(TagsPolicy::ability('index'));
    }

    /**
     * Render the component.
     *
     * @param  \Arcanesoft\Blog\Repositories\TagsRepository  $repo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(TagsRepository $repo)
    {
        return view('blog::tags._datatables.index', [
            'tags'   => $this->getResults($repo),
            'fields' => $this->getFields(),
        ]);
    }

    /**
     * Get the results.
     *
     * @param  \Arcanesoft\Blog\Repositories\TagsRepository  $repo
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getResults(TagsRepository $repo): LengthAwarePaginator
    {
        $results = $repo->withCount(['posts'])
            ->get();

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
            'name'        => $this->renderSortField('name', 'Name'),
            'posts_count' => __('Posts'),
            'created_at'  => $this->renderSortField('created', 'Created at'),
            'actions'     => __('Actions'),
        ];
    }
}
