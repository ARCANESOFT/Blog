<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Datatables;

use Arcanesoft\Blog\Http\Transformers\PostTransformer;
use Arcanesoft\Blog\Policies\PostsPolicy;
use Arcanesoft\Blog\Repositories\PostsRepository;
use Arcanesoft\Foundation\Datatable\{Action, Column, Datatable, Filter};
use Arcanesoft\Foundation\Datatable\Concerns\{HasActions, HasFilters, HasPagination};
use Arcanesoft\Foundation\Datatable\Contracts\Transformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class     PostsDatatable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsDatatable extends Datatable
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
     * @param  \Arcanesoft\Blog\Repositories\PostsRepository  $repo
     * @param  \Illuminate\Http\Request                       $request
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(PostsRepository $repo, Request $request)
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
            return $q->where('title', 'like', '%'.$search.'%');
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
            Column::make('title', 'Title')->sortable(),
            Column::make('created_at', 'Created at')->sortable()->align('center'),
            Column::make('published', 'Published', Column::DATATYPE_BADGE_ACTIVE)->sortable()->align('center')->escaped(false),
        ];
    }

    /**
     * Define the datatable actions.
     *
     * @param  \Illuminate\Http\Request            $request
     * @param  \Arcanesoft\Blog\Models\Post|mixed  $post
     *
     * @return array
     */
    protected function actions(Request $request, $post): array
    {
        $actions = [];

        $actions[] = Action::link('show', 'Show', function () use ($post) {
            return route('admin::blog.posts.show', [$post]);
        })->can(function () use ($post) {
            return PostsPolicy::can('show', [$post]);
        })->asIcon();

        $actions[] = Action::link('edit', 'Edit', function () use ($post) {
            return route('admin::blog.posts.edit', [$post]);
        })->can(function () use ($post) {
            return PostsPolicy::can('update', [$post]);
        })->asIcon();

        $actions[] = Action::button('delete', 'Delete', function () use ($post) {
            return "ARCANESOFT.emit('blog::posts.delete', {id: '{$post->getRouteKey()}'})";
        })->can(function () use ($post) {
            return PostsPolicy::can('delete', [$post]);
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
            Filter::select('published', 'Display', 'all', [
                'all'         => 'All',
                'published'   => 'Published',
                'unpublished' => 'Unpublished',
            ])->query(function(Builder $query, $value): Builder {
                return $value === 'published'
                    ? $query->whereNotNull('published_at')
                    : $query->whereNull('published_at');
            }),
        ];
    }

    /**
     * Get the transformer.
     *
     * @return \Arcanesoft\Foundation\Datatable\Contracts\Transformer
     */
    protected function transformer(): Transformer
    {
        return new PostTransformer;
    }
}
