@section('header')
    <h1><i class="fa fa-fw fa-bookmark-o"></i> Categories <small>{{ $category->name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Category details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table no-margin">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>
                                    <span class="label label-primary">{{ $category->slug }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nb. Posts</th>
                                <td>
                                    <span class="label label-{{ $category->posts->count() ? 'info' : 'default' }}">
                                        {{ $category->posts->count() }} Posts
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <small>{{ $category->created_at }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <small>{{ $category->updated_at }}</small>
                                </td>
                            </tr>
                            @if ($category->trashed())
                                <tr>
                                    <th>Deleted at</th>
                                    <td>
                                        <small>{{ $category->deleted_at }}</small>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    @can('blog.categories.update')
                        <a href="{{ route('admin::blog.categories.edit', [$category]) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-fw fa-pencil"></i> Update
                        </a>
                        @if ($category->trashed())
                        <button data-target="#restoreCategoryModal" data-toggle="modal" class="btn btn-sm btn-primary">
                            <i class="fa fa-fw fa-reply"></i> Restore
                        </button>
                        @endif
                    @endcan

                    @can('blog.categories.delete')
                        <button data-target="#deleteCategoryModal" data-toggle="modal" class="btn btn-sm btn-danger">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Posts</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th class="text-right" style="width: 80px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($category->hasPosts())
                                @foreach($category->posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            <span class="label label-primary">{{ $post->slug }}</span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin::blog.posts.show', [$post]) }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-fw fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <span class="label label-default">The list of categories is empty.</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @if ($category->trashed())
        @can('blog.categories.update')
            {{-- RESTORE MODAL --}}
            <div id="restoreCategoryModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreCategoryModalLabel">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::blog.categories.restore', $category], 'method' => 'PUT', 'id' => 'restoreCategoryForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="restoreCategoryModalLabel">Restore Category</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <span class="label label-primary">restore</span> this category : <strong>{{ $category->name }}</strong> ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Loading&hellip;">
                                    <i class="fa fa-fw fa-reply"></i> RESTORE
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endcan
    @endif

    @can('blog.categories.delete')
        {{-- DELETE MODAL --}}
        <div id="deleteCategoryModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::blog.categories.delete', $category], 'method' => 'DELETE', 'id' => 'deleteCategoryForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to <span class="label label-danger">delete</span> this category : <strong>{{ $category->name }}</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                                <i class="fa fa-fw fa-trash-o"></i> DELETE
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    @if ($category->trashed())
        @can('blog.categories.update')
        {{-- RESTORE SCRIPT --}}
        <script>
            var $restoreCategoryModal = $('div#restoreCategoryModal'),
                $restoreCategoryForm  = $('form#restoreCategoryForm');

            $restoreCategoryForm.on('submit', function (e) {
                e.preventDefault();

                var submitBtn = $restoreCategoryForm.find('button[type="submit"]');
                    submitBtn.button('loading');

                $.ajax({
                    url:      $restoreCategoryForm.attr('action'),
                    type:     $restoreCategoryForm.attr('method'),
                    dataType: 'json',
                    data:     $restoreCategoryForm.serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            $restoreCategoryModal.modal('hide');
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

    @can('blog.categories.delete')
    {{-- DELETE SCRIPT --}}
    <script>
        var $deleteCategoryModal = $('div#deleteCategoryModal'),
            $deleteCategoryForm  = $('form#deleteCategoryForm');

        $deleteCategoryForm.on('submit', function(e) {
            e.preventDefault();

            var submitBtn = $deleteCategoryForm.find('button[type="submit"]');
                submitBtn.button('loading');

            $.ajax({
                url:      $deleteCategoryForm.attr('action'),
                type:     $deleteCategoryForm.attr('method'),
                dataType: 'json',
                data:     $deleteCategoryForm.serialize(),
                success: function(data) {
                    if (data.status === 'success') {
                        $deleteCategoryModal.modal('hide');
                        location.replace("{{ route('admin::blog.categories.index') }}");
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
