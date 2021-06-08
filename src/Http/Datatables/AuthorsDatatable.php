<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Datatables;

use Arcanesoft\Blog\Http\Transformers\AuthorTransformer;
use Arcanesoft\Blog\Policies\AuthorsPolicy;
use Arcanesoft\Blog\Repositories\AuthorsRepository;
use Arcanesoft\Foundation\Datatable\{Action, Column, Datatable, Filter};
use Arcanesoft\Foundation\Datatable\Concerns\{HasActions, HasFilters, HasPagination};
use Arcanesoft\Foundation\Datatable\Contracts\Transformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class     AuthorsDatatable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorsDatatable extends Datatable
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasActions;
    use HasFilters;
    use HasPagination;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the datatable request.
     *
     * @param  \Arcanesoft\Blog\Repositories\AuthorsRepository  $repo
     * @param  \Illuminate\Http\Request                         $request
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(AuthorsRepository $repo, Request $request)
    {
        $query = $repo->query();

        $this->handleSearchQuery($request, $query);

        return $query;
    }

    /**
     * @param  \Illuminate\Http\Request               $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function handleSearchQuery(Request $request, Builder $query): Builder
    {
        $search = $this->searchQuery($request);

        return $query->unless(empty($search), function (Builder $q) use ($search) {
            return $q
                ->where('full_name', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%');
        });
    }

    /**
     * Define the datatable's columns.
     *
     * @return \Arcanesoft\Foundation\Datatable\Column[]|array
     */
    protected function columns(): array
    {
        return [
            Column::make('full_name', 'Full Name')->sortable(),
            Column::make('username', 'Username')->sortable(),
            Column::make('posts', 'Posts', Column::DATATYPE_BADGE_COUNT)->sortable()->align('center')->escaped(false),
            Column::make('created_at', 'Created at')->sortable()->align('center'),
        ];
    }

    /**
     * Define the datatable actions.
     *
     * @param  \Illuminate\Http\Request              $request
     * @param  \Arcanesoft\Blog\Models\Author|mixed  $author
     *
     * @return array
     */
    protected function actions(Request $request, $author): array
    {
        $actions = [];

        $actions[] = Action::link('show', 'Show', function () use ($author) {
            return route('admin::blog.authors.show', [$author]);
        })->can(function () use ($author) {
            return AuthorsPolicy::can('show', [$author]);
        })->asIcon();

        $actions[] = Action::link('edit', 'Edit', function () use ($author) {
            return route('admin::blog.authors.edit', [$author]);
        })->can(function () use ($author) {
            return AuthorsPolicy::can('update', [$author]);
        })->asIcon();

        $actions[] = Action::button('delete', 'Delete', function () use ($author) {
            return "ARCANESOFT.emit('blog::authors.delete', {id: '{$author->getRouteKey()}'})";
        })->can(function () use ($author) {
            return AuthorsPolicy::can('delete', [$author]);
        })->asIcon();

        return $actions;
    }

    /**
     * Define the datatable filters.
     *
     * @return \Arcanesoft\Foundation\Datatable\Contracts\Filter[]
     */
    protected function filters(Request $request): array
    {
        return [
//            Filter::select('published', 'Display', 'all', [
//                'all'         => 'All',
//                'published'   => 'Published',
//                'unpublished' => 'Unpublished',
//            ])->query(function(Builder $query, $value): Builder {
//                return $value === 'published'
//                    ? $query->whereNotNull('published_at')
//                    : $query->whereNull('published_at');
//            }),
        ];
    }

    /**
     * Get the transformer.
     *
     * @return \Arcanesoft\Foundation\Datatable\Contracts\Transformer
     */
    protected function transformer(): Transformer
    {
        return new AuthorTransformer;
    }
}
