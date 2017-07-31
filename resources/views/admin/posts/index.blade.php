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

                @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_CREATE)
                    {{ ui_link_icon('add', route('admin::blog.posts.create')) }}
                @endcan
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('blog::posts.attributes.locale') }}</th>
                            <th>{{ trans('blog::posts.attributes.category') }}</th>
                            <th>{{ trans('blog::posts.attributes.title') }}</th>
                            <th>{{ trans('blog::posts.attributes.slug') }}</th>
                            <th class="text-center" style="width: 80px;">{{ trans('core::generals.status') }}</th>
                            <th class="text-right" style="width: 130px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <?php /** @var  \Arcanesoft\Blog\Models\Post  $post */ ?>
                            <tr>
                                <td>
                                    <span class="label label-inverse">{{ strtoupper($post->locale) }}</span>
                                </td>
                                <td>
                                    <span class="label label-primary">{{ $post->category->name }}</span>
                                </td>
                                <td><b>{{ $post->title }}</b></td>
                                <td>
                                    <span class="label label-default">{{ $post->slug }}</span>
                                </td>
                                <td class="text-center">
                                    @include('blog::admin.posts._includes.post-status-name', compact('post'))
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::blog.posts.show', [$post])) }}
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::blog.posts.edit', [$post])) }}

                                        @if ($post->trashed())
                                            {{ ui_link_icon('restore', '#restore-post-modal', ['data-post-id' => $post->id, 'data-post-title' => $post->title]) }}
                                        @endif
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-post-modal', ['data-post-id' => $post->id, 'data-post-title' => $post->title]) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
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

@section('modals')
    {{-- RESTORE MODAL --}}
    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
        @if ($trashed)
            <div id="restore-post-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::blog.posts.restore', ':id'], 'method' => 'PUT', 'id' => 'restore-post-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::posts.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                                {{ ui_button('restore', 'submit')->withLoadingText() }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
        <div id="delete-post-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            {{ Form::open(['route' => ['admin::blog.posts.delete', ':id'], 'method' => 'DELETE', 'id' => 'delete-post-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{{ trans('blog::posts.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    @endcan
@endsection

@section('scripts')
    {{-- RESTORE SCRIPT --}}
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
        @if ($trashed)
            <script>
                $(function () {
                    var $restorePostModal = $('div#restore-post-modal'),
                        $restorePostForm  = $('form#restore-post-form'),
                        restorePostAction = $restorePostForm.attr('action');

                    $('a[href="#restore-post-modal"]').on('click', function (e) {
                        e.preventDefault();

                        var that = $(this);
                        $restorePostForm.attr('action', restorePostAction.replace(':id', that.attr('data-post-id')));
                        $restorePostForm.find('.modal-body p').html(
                            '{!! trans("blog::posts.modals.restore.message") !!}'.replace(':title', that.attr('data-post-title'))
                        );

                        $restorePostModal.modal('show');
                    });

                    $restorePostForm.on('submit', function (e) {
                        e.preventDefault();

                        var submitBtn = $restorePostForm.find('button[type="submit"]');
                            submitBtn.button('loading');

                        axios.put($restorePostForm.attr('action'))
                             .then(function (response) {
                                 if (response.data.code === 'success') {
                                     $restorePostModal.modal('hide');
                                     location.reload();
                                 }
                             })
                             .catch(function (error) {
                                 alert('AJAX ERROR ! Check the console !');
                                 console.log(error);
                                 submitBtn.button('reset');
                             });

                        return false;
                    });

                    $restorePostModal.on('hidden.bs.modal', function (e) {
                        $restorePostForm.attr('action', restorePostAction);
                        $restorePostForm.find('.modal-body p').html('');
                    });
                });
            </script>
        @endif
    @endcan

    {{-- DELETE SCRIPT --}}
    @can(Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
        <script>
            $(function () {
                var $deletePostModal = $('div#delete-post-modal'),
                    $deletePostForm  = $('form#delete-post-form'),
                    deletePostAction = $deletePostForm.attr('action');

                $('a[href="#delete-post-modal"]').on('click', function (e) {
                    e.preventDefault();

                    var that = $(this);

                    $deletePostForm.attr('action', deletePostAction.replace(':id', that.attr('data-post-id')));
                    $deletePostForm.find('.modal-body p').html(
                        '{!! trans("blog::posts.modals.delete.message") !!}'.replace(':title', that.attr('data-post-title'))
                    );

                    $deletePostModal.modal('show');
                });

                $deletePostForm.on('submit', function (e) {
                    e.preventDefault();

                    var submitBtn = $deletePostForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.delete($deletePostForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
                                 $deletePostModal.modal('hide');
                                 location.reload();
                             }
                         })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             submitBtn.button('reset');
                         });

                    return false;
                });

                $deletePostModal.on('hidden.bs.modal', function () {
                    $deletePostForm.attr('action', deletePostAction);
                    $deletePostForm.find('.modal-body p').html('');
                });
            });
        </script>
    @endcan
@endsection
