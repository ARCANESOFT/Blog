<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $posts */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> {{ trans('blog::posts.titles.posts') }} <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $posts])

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::blog.posts.index') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.posts.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> {{ trans('core::generals.all') }}
                    </a>
                    <a href="{{ route('admin::blog.posts.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.posts.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> {{ trans('core::generals.trashed') }}
                    </a>
                </div>

                {{ ui_link_icon('add', route('admin::blog.posts.create')) }}
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('blog::posts.attributes.category') }}</th>
                            <th>{{ trans('blog::posts.attributes.title') }}</th>
                            <th class="text-center" style="width: 80px;">{{ trans('core::generals.status') }}</th>
                            <th class="text-right" style="width: 130px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <?php /** @var  \Arcanesoft\Blog\Models\Post  $post */ ?>
                            <tr>
                                <td>
                                    <span class="label label-primary">{{ $post->category->name }}</span>
                                </td>
                                <td>{{ $post->title }}</td>
                                <td class="text-center">
                                    @include('blog::admin.posts._includes.post-status-name', compact('post'))
                                </td>
                                <td class="text-right">
                                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::blog.posts.show', [$post])) }}
                                    @endcan

                                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::blog.posts.edit', [$post])) }}

                                        @if ($post->trashed())
                                            {{ ui_link_icon('restore', '#resotre-post-modal', ['data-post-id' => $post->id]) }}
                                        @endif
                                    @endcan

                                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-post-modal', ['data-post-id' => $post->id]) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">{{ trans('blog::posts.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($posts->hasPages())
            <div class="box-footer clearfix">{!! $posts->render() !!}</div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
