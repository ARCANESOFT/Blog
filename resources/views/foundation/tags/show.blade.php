@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> Tags <small>{{ $tag->name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Tag details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $tag->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>
                                    <span class="label label-primary">{{ $tag->slug }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nb. Posts</th>
                                <td>
                                    <span class="label label-{{ $tag->posts->count() ? 'info' : 'default' }}">
                                        {{ $tag->posts->count() }} Posts
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <small>{{ $tag->created_at }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <small>{{ $tag->updated_at }}</small>
                                </td>
                            </tr>
                            @if ($tag->trashed())
                                <tr>
                                    <th>Deleted at</th>
                                    <td>
                                        <small>{{ $tag->deleted_at }}</small>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    @can('blog.tags.update')
                        <a href="{{ route('blog::foundation.categories.edit', [$tag->id]) }}" class="btn btn-xs btn-warning">
                            <i class="fa fa-fw fa-pencil"></i> Update
                        </a>

                        @if ($tag->trashed())
                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#restoreTagModal">
                                <i class="fa fa-fw fa-reply"></i> Restore
                            </button>
                        @endif
                    @endcan

                    @can('blog.tags.delete')
                        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteTagModal">
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
                            @if ($tag->posts->count())
                                @foreach($tag->posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            <span class="label label-primary">{{ $post->slug }}</span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('blog::foundation.posts.show', [$post->id]) }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-fw fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <span class="label label-default">The list of posts is empty.</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($tag->trashed())
        @can('blog.tags.update')
        {{-- RESTORE MODAL --}}
        <div id="restoreTagModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreTagModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['route' => ['blog::foundation.tags.restore', $tag->id], 'method' => 'PUT', 'id' => 'restoreTagForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="restoreTagModalLabel">Restore Tag</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <span class="label label-primary">restore</span> this tag : <strong>{{ $tag->name }}</strong> ?</p>
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

    @can('blog.tags.delete')
    {{-- DELETE MODAL --}}
    <div id="deleteTagModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteTagModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => ['blog::foundation.tags.delete', $tag->id], 'method' => 'DELETE', 'id' => 'deleteTagForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteTagModalLabel">Delete Tag</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <span class="label label-danger">delete</span> this tag : <strong>{{ $tag->name }}</strong> ?</p>
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
    @if ($tag->trashed())
        @can('blog.tags.update')
        {{-- RESTORE SCRIPT --}}
        <script>
            var restoreTagModal = $('div#restoreTagModal'),
                restoreTagForm  = $('form#restoreTagForm');

            restoreTagForm.submit(function (event) {
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
                            restoreTagModal.modal('hide');
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
        var deleteTagModal = $('div#deleteTagModal'),
            deleteTagForm  = $('form#deleteTagForm');

        deleteTagForm.submit(function (event) {
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
                        deleteTagModal.modal('hide');
                        location.replace("{{ route('blog::foundation.tags.index') }}");
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
