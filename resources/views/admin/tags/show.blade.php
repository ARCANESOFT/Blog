<?php /** @var  \Arcanesoft\Blog\Models\Tag  $tag */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> {{ trans('blog::tags.titles.tags') }} <small>{{ $tag->name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- TAG DETAILS --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('blog::tags.titles.tag-details') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                            <tr>
                                <th>{{ trans('blog::tags.attributes.name') }} :</th>
                                <td>{{ $tag->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('blog::tags.attributes.slug') }} :</th>
                                <td>
                                    <span class="label label-primary">{{ $tag->slug }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('blog::posts.titles.posts') }} :</th>
                                <td>
                                    {{ label_count($tag->posts->count()) }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('core::generals.created_at') }} :</th>
                                <td>
                                    <small>{{ $tag->created_at }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('core::generals.updated_at') }} :</th>
                                <td>
                                    <small>{{ $tag->updated_at }}</small>
                                </td>
                            </tr>
                            @if ($tag->trashed())
                                <tr>
                                    <th>{{ trans('core::generals.deleted_at') }} :</th>
                                    <td>
                                        <small>{{ $tag->deleted_at }}</small>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
                        {{ ui_link('edit', route('admin::blog.tags.edit', [$tag])) }}

                        @if ($tag->trashed())
                            {{ ui_link('restore', '#restore-tag-modal') }}
                        @endif
                    @endcan

                    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
                        {{ ui_link('delete', '#delete-tag-modal') }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{-- POSTS --}}
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('blog::posts.titles.posts') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover no-margin">
                            <thead>
                                <tr>
                                    <th>{{ trans('blog::posts.attributes.title') }}</th>
                                    <th>{{ trans('blog::posts.attributes.slug') }}</th>
                                    <th class="text-right" style="width: 80px;">{{ trans('core::generals.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tag->posts as $post)
                                    <?php /** @var  \Arcanesoft\Blog\Models\Post  $post */ ?>
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            <span class="label label-primary">{{ $post->slug }}</span>
                                        </td>
                                        <td class="text-right">
                                            @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_SHOW)
                                                {{ ui_link('show', route('admin::blog.posts.show', [$post])) }}
                                            @endcan

                                            @can(\Arcanesoft\Blog\Policies\PostsPolicy::PERMISSION_UPDATE)
                                                {{ ui_link('edit', route('admin::blog.posts.edit', [$post])) }}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <span class="label label-default">{{ trans('blog::tags.has-no-posts') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- RESTORE MODAL --}}
    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
        @if ($tag->trashed())
            <div id="restore-tag-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::blog.tags.restore', $tag], 'method' => 'PUT', 'id' => 'restore-tag-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::tags.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{!! trans('blog::tags.modals.restore.message', ['name' => $tag->name]) !!}</p>
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
    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
        <div id="delete-tag-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::blog.tags.delete', $tag], 'method' => 'DELETE', 'id' => 'delete-tag-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('blog::tags.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('blog::tags.modals.delete.message', ['name' => $tag->name]) !!}</p>
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
    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
        @if ($tag->trashed())
        <script>
            $(function () {
                var $restoreTagModal = $('div#restore-tag-modal'),
                    $restoreTagForm  = $('form#restore-tag-form');

                $('a[href="#restore-tag-modal"]').on('click', function (e) {
                    e.preventDefault();

                    $restoreTagModal.modal('show');
                });

                $restoreTagForm.on('submit', function (e) {
                    e.preventDefault();

                    var submitBtn = $restoreTagForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.put($restoreTagForm.attr('action'))
                         .then(function (response) {
                             if (response.data.status === 'success') {
                                 $restoreTagModal.modal('hide');
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
    @can(\Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
    <script>
        $(function () {
            var $deleteTagModal = $('div#delete-tag-modal'),
                $deleteTagForm  = $('form#delete-tag-form');

            $('a[href="#delete-tag-modal"]').on('click', function (e) {
                e.preventDefault();

                $deleteTagModal.modal('show');
            });

            $deleteTagForm.on('submit', function (e) {
                e.preventDefault();

                var submitBtn = $deleteTagForm.find('button[type="submit"]');
                    submitBtn.button('loading');

                axios.delete($deleteTagForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $deleteTagModal.modal('hide');
                             @if ($tag->trashed())
                                 location.replace("{{ route('admin::blog.tags.index') }}");
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
