<?php /** @var  Illuminate\Pagination\LengthAwarePaginator  $tags */ ?>

@inject('blog', 'Arcanesoft\Blog\Blog')

@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> {{ trans('blog::tags.titles.tags') }} <small>{{ trans('blog::tags.titles.tags-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $tags])

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::blog.tags.index') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.tags.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> {{ trans('core::generals.all') }}
                    </a>
                    <a href="{{ route('admin::blog.tags.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.tags.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> {{ trans('core::generals.trashed') }}
                    </a>
                </div>

                {{ ui_link_icon('add', route('admin::blog.tags.create')) }}
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('blog::tags.attributes.name') }}</th>
                            <th>{{ trans('blog::tags.attributes.slug') }}</th>
                            <th class="text-center" style="width: 80px;">{{ trans('blog::posts.titles.posts') }}</th>
                            <th class="text-right" style="width: 130px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <?php /** @var  Arcanesoft\Blog\Models\Tag  $tag */ ?>
                            <tr>
                                <td>
                                    @if ($blog->isTranslatable())
                                        @foreach($tag->getTranslations('name') as $name)
                                            <span class="label label-inverse">{{ $name }}</span>
                                        @endforeach
                                    @else
                                        <span class="label label-inverse">{{ $tag->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($blog->isTranslatable())
                                        @foreach($tag->getTranslations('slug') as $slug)
                                            <span class="label label-primary">{{ $slug }}</span>
                                        @endforeach
                                    @else
                                        <span class="label label-inverse">{{ $tag->slug }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ label_count($tag->posts->count()) }}
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::blog.tags.show', [$tag])) }}
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::blog.tags.edit', [$tag])) }}
                                        @if ($tag->trashed())
                                            {{ ui_link_icon('restore', '#restore-tag-modal', ['data-tag-id' => $tag->id, 'data-tag-name' => $tag->name]) }}
                                        @endif
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-tag-modal', ['data-tag-id' => $tag->id, 'data-tag-name' => $tag->name]) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">{{ trans('blog::tags.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($tags->hasPages())
            <div class="box-footer clearfix">{!! $tags->render() !!}</div>
        @endif
    </div>
@endsection

@section('modals')
    {{-- RESTORE MODAL --}}
    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
        @if ($trashed)
            <div id="restore-tag-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['method' => 'PUT', 'id' => 'restore-tag-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::tags.modals.restore.title') }}</h4>
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
    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
        <div id="delete-tag-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'delete-tag-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('blog::tags.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
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
    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_UPDATE)
        @if ($trashed)
        <script>
            $(function () {
                var $restoreTagModal = $('div#restore-tag-modal'),
                    $restoreTagForm  = $('form#restore-tag-form'),
                    restoreTagAction = "{{ route('admin::blog.tags.restore', [':id']) }}";

                $('a[href="#restore-tag-modal"]').on('click', function (e) {
                    e.preventDefault();

                    var that = $(this);

                    $restoreTagForm.attr('action', restoreTagAction.replace(':id', that.attr('data-tag-id')));
                    $restoreTagModal.find('.modal-body p').html(
                        '{!! trans("blog::tags.modals.restore.message") !!}'.replace(':name', that.attr('data-tag-name'))
                    );

                    $restoreTagModal.modal('show');
                });

                $restoreTagModal.on('hidden.bs.modal', function () {
                    $restoreTagForm.attr('action', restoreTagAction);
                    $restoreTagModal.find('.modal-body p').html('');
                });

                $restoreTagForm.submit(function (e) {
                    e.preventDefault();

                    var submitBtn = $restoreTagForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.put($restoreTagForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
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
    @can(Arcanesoft\Blog\Policies\TagsPolicy::PERMISSION_DELETE)
    <script>
        var $deleteTagModal = $('div#delete-tag-modal'),
            $deleteTagForm  = $('form#delete-tag-form'),
            deleteTagAction = "{{ route('admin::blog.tags.delete', [':id']) }}";

        $('a[href="#delete-tag-modal"]').on('click', function (e) {
            e.preventDefault();

            var that = $(this);

            $deleteTagForm.attr('action', deleteTagAction.replace(':id', that.attr('data-tag-id')));
            $deleteTagModal.find('.modal-body p').html(
                '{!! trans('blog::tags.modals.delete.message') !!}'.replace(':name', that.attr('data-tag-name'))
            );

            $deleteTagModal.modal('show');
        });

        $deleteTagModal.on('hidden.bs.modal', function () {
            $deleteTagForm.attr('action', deleteTagAction);
            $deleteTagModal.find('.modal-body p').html('');
        });

        $deleteTagForm.on('submit', function (e) {
            e.preventDefault();

            var submitBtn = $deleteTagForm.find('button[type="submit"]');
                submitBtn.button('loading');

            axios.delete($deleteTagForm.attr('action'))
                 .then(function (response) {
                     if (response.data.code === 'success') {
                         $deleteTagModal.modal('hide');
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
    </script>
    @endcan
@endsection
