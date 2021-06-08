<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Datatables;

use Arcanesoft\Blog\Http\Transformers\TagTransformer;
use Arcanesoft\Blog\Policies\TagsPolicy;
use Arcanesoft\Blog\Repositories\TagsRepository;
use Arcanesoft\Foundation\Datatable\{Action, Column, Datatable, Filter};
use Arcanesoft\Foundation\Datatable\Concerns\{HasActions, HasFilters, HasPagination};
use Arcanesoft\Foundation\Datatable\Contracts\Transformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class     TagsDatatable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsDatatable extends Datatable
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
     * @param  \Arcanesoft\Blog\Repositories\TagsRepository  $repo
     * @param  \Illuminate\Http\Request                       $request
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(TagsRepository $repo, Request $request)
    {
        $query = $repo->query()->withCount(['posts']);

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
            return $q->where('name', 'like', '%'.$search.'%');
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
            Column::make('name', 'Name')->sortable(),
            Column::make('posts', 'Posts', Column::DATATYPE_BADGE_COUNT)->sortable()->align('center')->escaped(false),
            Column::make('created_at', 'Created at')->sortable()->align('center'),
        ];
    }

    /**
     * Define the datatable actions.
     *
     * @param  \Illuminate\Http\Request           $request
     * @param  \Arcanesoft\Blog\Models\Tag|mixed  $tag
     *
     * @return array
     */
    protected function actions(Request $request, $tag): array
    {
        $actions = [];

        $actions[] = Action::link('show', 'Show', function () use ($tag) {
            return route('admin::blog.tags.show', [$tag]);
        })->can(function () use ($tag) {
            return TagsPolicy::can('show', [$tag]);
        })->asIcon();

        $actions[] = Action::link('edit', 'Edit', function () use ($tag) {
            return route('admin::blog.tags.edit', [$tag]);
        })->can(function () use ($tag) {
            return TagsPolicy::can('update', [$tag]);
        })->asIcon();

        $actions[] = Action::button('delete', 'Delete', function () use ($tag) {
            return "ARCANESOFT.emit('blog::tags.delete', {id: '{$tag->getRouteKey()}'})";
        })->can(function () use ($tag) {
            return TagsPolicy::can('delete', [$tag]);
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
        return new TagTransformer;
    }
}
