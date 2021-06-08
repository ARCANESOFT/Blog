<?php
/**
 * @var  Arcanesoft\Blog\Models\Tag[]|Illuminate\Pagination\LengthAwarePaginator  $tags
 * @var  array                                                                    $fields
 */
?>
<div class="card card-borderless shadow-sm">
    @if ($tags->isNotEmpty())
        <div class="card-header px-2">
            @include('foundation::_components.datatable.datatable-header')
        </div>
        <div class="table-responsive">
            <table id="posts-table" class="table table-borderless table-hover mb-0">
                <thead>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">{{ $fields['name'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-center">{{ $fields['posts_count'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-center">{{ $fields['created_at'] }}</th>
                        <th class="font-weight-light text-uppercase text-muted text-right">{{ $fields['actions'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                    <tr>
                        <td class="small">{{ $tag->name }}</td>
                        <td class="text-center small">{{ arcanesoft\ui\count_pill($tag->posts_count) }}</td>
                        <td class="text-center small">{{ $tag->created_at }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin::blog.tags.show', [$tag]) }}" class="btn btn-sm btn-light"
                               data-toggle="tooltip" title="@lang('Show')"><i class="far fa-fw fa-eye"></i></a>
                            <a href="{{ route('admin::blog.tags.edit', [$tag]) }}" class="btn btn-sm btn-light"
                               data-toggle="tooltip" title="@lang('Edit')"><i class="far fa-fw fa-edit"></i></a>
                            <button onclick="Foundation.$emit('admin::blog.tags.delete', {id: '{{ $tag->getRouteKey() }}'})"
                                    class="btn btn-sm btn-light text-danger" type="button"
                                    data-toggle="tooltip" title="@lang('Delete')">
                                <i class="far fa-fw fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer px-2">
            @include('foundation::_components.datatable.datatable-footer', ['paginator' => $tags])
        </div>
    @else
        @include('foundation::_partials.no-data-found')
    @endif
</div>
