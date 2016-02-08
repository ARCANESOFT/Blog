@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> Categories <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total of categories : {{ $categories->total() }}
            </span>

            @if ($categories->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $categories->currentPage(), 'last' => $categories->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('blog::foundation.categories.index') }}" class="btn btn-xs btn-default {{ route_is('blog::foundation.categories.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> All
                    </a>
                    <a href="{{ route('blog::foundation.categories.trash') }}" class="btn btn-xs btn-default {{ route_is('blog::foundation.categories.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> Trashed
                    </a>
                </div>

                <a href="{{ route('blog::foundation.categories.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="text-center" style="width: 80px;">Nb. posts</th>
                            <th class="text-right" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categories->count())
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <span class="label label-primary">{{ $category->slug }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-{{ $category->posts->count() ? 'info' : 'default' }}">
                                            {{ $category->posts->count() }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('blog::foundation.categories.show', [$category->id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                        <a href="{{ route('blog::foundation.categories.edit', [$category->id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </a>
                                        @if ($category->trashed())
                                            <a href="#restoreCategoryModal" class="btn btn-xs btn-primary" data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}" data-toggle="tooltip" data-original-title="Restore">
                                                <i class="fa fa-fw fa-reply"></i>
                                            </a>
                                        @endif
                                        <a href="#deleteCategoryModal" class="btn btn-xs btn-danger" data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">The list of categories is empty.</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($categories->hasPages())
            <div class="box-footer clearfix">{!! $categories->render() !!}</div>
        @endif
    </div>

    @if ($trashed)
        @can('blog.categories.update')
        {{-- RESTORE MODAL --}}
        <div id="restoreCategoryModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreCategoryModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['method' => 'PUT', 'id' => 'restoreCategoryForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="restoreCategoryModalLabel">Restore Category</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-reply"></i> RESTORE
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @endcan
    @endif

    @can('blog.categories.delete')
    {{-- DELETE MODAL --}}
    <div id="deleteCategoryModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'DELETE', 'id' => 'deleteCategoryForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                        <i class="fa fa-fw fa-trash-o"></i> DELETE
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @endcan
@endsection

@section('scripts')
    @if ($trashed)
        @can('blog.tags.update')
        {{-- RESTORE SCRIPT --}}
        <script>
            var restoreCategoryModal = $('div#restoreCategoryModal'),
                restoreCategoryForm  = $('form#restoreCategoryForm'),
                restoreCategoryUrl   = "{{ route('blog::foundation.categories.restore', [':id']) }}";

            $('a[href="#restoreCategoryModal"]').click(function (event) {
                event.preventDefault();
                var modalMessage = 'Are you sure you want to <span class="label label-primary">restore</span> this category : <strong>:category</strong> ?';

                restoreCategoryForm.attr('action', restoreCategoryUrl.replace(':id', $(this).data('category-id')));
                restoreCategoryModal.find('.modal-body p').html(modalMessage.replace(':category', $(this).data('category-name')));

                restoreCategoryModal.modal('show');
            });

            restoreCategoryModal.on('hidden.bs.modal', function () {
                restoreCategoryForm.removeAttr('action');
                $(this).find('.modal-body p').html('');
            });

            restoreCategoryForm.submit(function (event) {
                event.preventDefault();
                var submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            restoreCategoryModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            submitBtn.button('reset');
                        }
                    },
                    error: function(xhr) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });
        </script>
        @endcan
    @endif

    @can('blog.tags.delete')
    {{-- DELETE SCRIPT --}}
    <script>
        var deleteCategoryModal = $('div#deleteCategoryModal'),
            deleteCategoryForm  = $('form#deleteCategoryForm'),
            deleteCategoryUrl   = "{{ route('blog::foundation.categories.delete', [':id']) }}";

        $('a[href="#deleteCategoryModal"]').click(function (event) {
            event.preventDefault();
            var modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this category : <strong>:category</strong> ?';

            deleteCategoryForm.attr('action', deleteCategoryUrl.replace(':id', $(this).data('category-id')));
            deleteCategoryModal.find('.modal-body p').html(modalMessage.replace(':category', $(this).data('category-name')));

            deleteCategoryModal.modal('show');
        });

        deleteCategoryModal.on('hidden.bs.modal', function () {
            deleteCategoryForm.removeAttr('action');
            $(this).find('.modal-body p').html('');
        });

        deleteCategoryForm.submit(function (event) {
            event.preventDefault();
            var submitBtn = $(this).find('button[type="submit"]');
                submitBtn.button('loading');

            $.ajax({
                url:      $(this).attr('action'),
                type:     $(this).attr('method'),
                dataType: 'json',
                data:     $(this).serialize(),
                success: function(data) {
                    if (data.status === 'success') {
                        deleteCategoryModal.modal('hide');
                        location.reload();
                    }
                    else {
                        alert('ERROR ! Check the console !');
                        console.error(data.message);
                        submitBtn.button('reset');
                    }
                },
                error: function(xhr) {
                    alert('AJAX ERROR ! Check the console !');
                    console.error(xhr);
                    submitBtn.button('reset');
                }
            });

            return false;
        });
    </script>
    @endcan
@endsection
