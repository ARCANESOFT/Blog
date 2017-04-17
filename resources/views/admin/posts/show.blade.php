<?php /** @var  \Arcanesoft\Blog\Models\Post  $post */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> {{ trans('blog::posts.titles.posts') }} <small>{{ $post->title }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5 col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">{{ trans('blog::posts.titles.post-details') }}</h2>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.title') }}:</b><br>
                                        {{ $post->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.category') }}:</th>
                                    <td class="text-right">
                                        <span class="label label-primary">{{ $post->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.author') }}:</th>
                                    <td class="text-right">
                                        <span class="label label-inverse">{{ $post->author->full_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.slug') }}:</b><br>
                                        {{ $post->slug }}
                                    </td>
                                </tr>
                                @if (Route::has('public::blog.posts.show'))
                                    <tr>
                                        <td colspan="2">
                                            <b>{{ trans('blog::posts.attributes.permalink') }}:</b><br>
                                            {{ route('public::blog.posts.show', [$post->slug]) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.excerpt') }}:</b><br>
                                        {{ $post->excerpt }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>{{ trans('blog::posts.attributes.tags') }}:</b><br>
                                        @foreach ($post->tags as $tag)
                                            <?php /** @var  \Arcanesoft\Blog\Models\Tag  $tag */ ?>
                                            <span class="label label-info">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.status') }}:</th>
                                    <td class="text-right">
                                        @include('blog::admin.posts._includes.post-status-name', compact('post'))
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.published_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->published_at }}</small>
                                    </td>
                                </tr>
                                @if ($post->trashed())
                                <tr>
                                    <th>{{ trans('core::generals.deleted_at') }}:</th>
                                    <td class="text-right">
                                        <small>{{ $post->deleted_at }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                        {{ ui_link('edit', route('admin::blog.posts.edit', [$post])) }}

                        @if ($post->trashed())
                            {{ ui_link('restore', '#restore-post-modal') }}
                        @endif
                    @endcan

                    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
                        {{ ui_link('delete', '#delete-post-modal') }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-8">
            {{-- POST CONTENT --}}
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('blog::posts.attributes.content') }}</h2>
                    <div class="box-tools">
                        <ul class="nav nav-pills nav-sm" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#content_html" aria-controls="content_html" role="tab" data-toggle="tab">HTML</a>
                            </li>
                            <li role="presentation">
                                <a href="#content_raw" aria-controls="content_raw" role="tab" data-toggle="tab">RAW</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="content_html">
                            {{ $post->content }}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="content_raw">
                            <pre>{{ $post->content_raw }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- RESTORE MODAL --}}
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
        @if ($post->trashed())
            <div id="restore-post-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::blog.posts.restore', $post], 'method' => 'PUT', 'id' => 'restore-post-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::posts.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{!! trans('blog::posts.modals.restore.message', ['title' => $post->title]) !!}</p>
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
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
        <div id="delete-post-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::blog.posts.delete', $post], 'method' => 'DELETE', 'id' => 'delete-post-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('blog::posts.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('blog::posts.modals.delete.message', ['title' => $post->title]) !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    {{-- RESTORE SCRIPT --}}
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
        @if ($post->trashed())
            <script>
                $(function () {
                    var $restorePostModal = $('div#restore-post-modal'),
                        $restorePostForm  = $('form#restore-post-form');

                    $('a[href="#restore-post-modal"]').on('click', function (e) {
                        e.preventDefault();

                        $restorePostModal.modal('show');
                    });

                    $restorePostForm.on('submit', function (e) {
                        e.preventDefault();

                        var submitBtn = $restorePostForm.find('button[type="submit"]');
                            submitBtn.button('loading');

                        axios.put($restorePostForm.attr('action'))
                             .then(function (response) {
                                 if (response.data.status === 'success') {
                                     $restorePostModal.modal('hide');
                                     location.reload();
                                 }
                                 else {
                                     alert('ERROR ! Check the console !');
                                     console.error(response.data.message);
                                     submitBtn.button('reset');
                                 }
                             })
                             .catch(function (error) {
                                 alert('AJAX ERROR ! Check the console !');
                                 console.log(error);
                                 submitBtn.button('reset');
                             });

                        return false;
                    });
                });
            </script>
        @endif
    @endcan

    {{-- DELETE SCRIPT --}}
    @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_DELETE)
        <script>
            $(function () {
                var $deletePostModal = $('div#delete-post-modal'),
                    $deletePostForm  = $('form#delete-post-form');

                $('a[href="#delete-post-modal"]').on('click', function (e) {
                    e.preventDefault();

                    $deletePostModal.modal('show');
                });

                $deletePostForm.on('submit', function (e) {
                    e.preventDefault();

                    var submitBtn = $deletePostForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.delete($deletePostForm.attr('action'))
                         .then(function (response) {
                             if (response.data.status === 'success') {
                                 $deletePostModal.modal('hide');
                                 @if ($post->trashed())
                                     location.replace("{{ route('admin::blog.posts.index') }}");
                                 @else
                                     location.reload();
                                 @endif
                             }
                             else {
                                 alert('ERROR ! Check the console !');
                                 console.error(response.data.message);
                                 submitBtn.button('reset');
                             }
                         })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             submitBtn.button('reset');
                         });

                    return false;
                });
            });
        </script>
    @endcan
@endsection
