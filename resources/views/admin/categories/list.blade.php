<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $categories */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-bookmark-o"></i> {{ trans('blog::categories.titles.categories') }} <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $categories])

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::blog.categories.index') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.categories.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> {{ trans('core::generals.all') }}
                    </a>
                    <a href="{{ route('admin::blog.categories.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.categories.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> {{ trans('core::generals.trashed') }}
                    </a>
                </div>

                {{ ui_link_icon('add', route('admin::blog.categories.create')) }}
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('blog::categories.attributes.name') }}</th>
                            <th>{{ trans('blog::categories.attributes.slug') }}</th>
                            <th class="text-center" style="width: 80px;">{{ trans('blog::posts.titles.posts') }}</th>
                            <th class="text-right" style="width: 130px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <?php /** @var  \Arcanesoft\Blog\Models\Category  $category */ ?>
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <span class="label label-primary">{{ $category->slug }}</span>
                                </td>
                                <td class="text-center">
                                    {{ label_count($category->posts->count()) }}
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::blog.categories.show', [$category])) }}
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::blog.categories.edit', [$category])) }}

                                        @if ($category->trashed())
                                            {{ ui_link_icon('restore', '#restore-category-modal', ['data-category-id' => $category->id, 'data-category-name' => $category->name]) }}
                                        @endif
                                    @endcan

                                    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-category-modal', ['data-category-id' => $category->id, 'data-category-name' => $category->name]) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">{{ trans('blog::categories.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($categories->hasPages())
            <div class="box-footer clearfix">{!! $categories->render() !!}</div>
        @endif
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_UPDATE)
        @if ($trashed)
            {{-- RESTORE MODAL --}}
            <div id="restore-category-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['method' => 'PUT', 'id' => 'restore-category-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('blog::categories.modals.restore.title') }}</h4>
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

    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
        {{-- DELETE MODAL --}}
        <div id="delete-category-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'delete-category-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('blog::categories.modals.delete.title') }}</h4>
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
    @if ($trashed)
        @can('blog.tags.update')
        {{-- RESTORE SCRIPT --}}
        <script>
            $(function () {
                var $restoreCategoryModal = $('div#restore-category-modal'),
                    $restoreCategoryForm  = $('form#restore-category-form'),
                    restoreCategoryAction = "{{ route('admin::blog.categories.restore', [':id']) }}";

                $('a[href="#restore-category-modal"]').click(function (e) {
                    e.preventDefault();

                    var that    = $(this),
                        message = '{!! trans("blog::categories.modals.restore.message") !!}';

                    $restoreCategoryForm.attr('action', restoreCategoryAction.replace(':id', that.attr('data-category-id')));
                    $restoreCategoryModal.find('.modal-body p').html(message.replace(':name', that.attr('data-category-name')));

                    $restoreCategoryModal.modal('show');
                });

                $restoreCategoryModal.on('hidden.bs.modal', function () {
                    $restoreCategoryForm.attr('action', restoreCategoryAction);

                    $restoreCategoryModal.find('.modal-body p').html('');
                });

                $restoreCategoryForm.on('submit', function(e) {
                    e.preventDefault();

                    var submitBtn = $restoreCategoryForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.put($restoreCategoryForm.attr('action'))
                         .then(function (response) {
                             if (response.data.status === 'success') {
                                 $restoreCategoryModal.modal('hide');
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
        @endcan
    @endif

    @can(Arcanesoft\Blog\Policies\CategoriesPolicy::PERMISSION_DELETE)
    {{-- DELETE SCRIPT --}}
    <script>
        $(function () {
            var $deleteCategoryModal = $('div#delete-category-modal'),
                $deleteCategoryForm  = $('form#delete-category-form'),
                deleteCategoryAction = "{{ route('admin::blog.categories.delete', [':id']) }}";

            $('a[href="#deleteCategoryModal"]').click(function (e) {
                e.preventDefault();

                var that    = $(this),
                    message = '{!! trans("blog::categories.modals.delete.message") !!}';

                $deleteCategoryForm.attr('action', deleteCategoryAction.replace(':id', that.attr('data-category-id')));
                $deleteCategoryModal.find('.modal-body p').html(message.replace(':category', that.attr('data-category-name')));

                $deleteCategoryModal.modal('show');
            });

            $deleteCategoryModal.on('hidden.bs.modal', function() {
                $deleteCategoryForm.attr('action', deleteCategoryAction);
                $deleteCategoryModal.find('.modal-body p').html('');
            });

            $deleteCategoryForm.on('submit', function (e) {
                e.preventDefault();

                var submitBtn = $deleteCategoryForm.find('button[type="submit"]');
                    submitBtn.button('loading');

                axios.delete($deleteCategoryForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $deleteCategoryModal.modal('hide');
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
    @endcan
@endsection
