@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> Tags <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total of tags : {{ $tags->total() }}
            </span>

            @if ($tags->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $tags->currentPage(), 'last' => $tags->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::blog.tags.index') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.tags.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> All
                    </a>
                    <a href="{{ route('admin::blog.tags.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::blog.tags.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> Trashed
                    </a>
                </div>

                <a href="{{ route('admin::blog.tags.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="text-center" style="width: 80px;">Nb. posts</th>
                            <th class="text-right" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tags->count())
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td>
                                        <span class="label label-primary">{{ $tag->slug }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-{{ $tag->hasPosts() ? 'info' : 'default' }}">
                                            {{ $tag->posts->count() }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin::blog.tags.show', [$tag]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                        <a href="{{ route('admin::blog.tags.edit', [$tag]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </a>
                                        @if ($tag->trashed())
                                            <a href="#restoreTagModal" class="btn btn-xs btn-primary" data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}" data-toggle="tooltip" data-original-title="Restore">
                                                <i class="fa fa-fw fa-reply"></i>
                                            </a>
                                        @endif
                                        <a href="#deleteTagModal" class="btn btn-xs btn-danger" data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">The list of tags is empty.</span>
                                </td>
                            </tr>
                        @endif
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
    @if ($trashed)
        @can('blog.tags.update')
            {{-- RESTORE MODAL --}}
            <div id="restoreTagModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreTagModalLabel">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['method' => 'PUT', 'id' => 'restoreTagForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="restoreTagModalLabel">Restore Tag</h4>
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
                    {{ Form::close() }}
                </div>
            </div>
        @endcan
    @endif

    @can('blog.tags.delete')
        {{-- DELETE MODAL --}}
        <div id="deleteTagModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteTagModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'deleteTagForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteTagModalLabel">Delete Tag</h4>
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
            var $restoreTagModal = $('div#restoreTagModal'),
                $restoreTagForm  = $('form#restoreTagForm'),
                restoreTagUrl   = "{{ route('admin::blog.tags.restore', [':id']) }}";

            $('a[href="#restoreTagModal"]').click(function (event) {
                event.preventDefault();

                var $this         = $(this),
                    modalMessage = 'Are you sure you want to <span class="label label-primary">restore</span> this tag : <strong>:tag</strong> ?';

                $restoreTagForm.attr('action', restoreTagUrl.replace(':id', $this.data('tag-id')));
                $restoreTagModal.find('.modal-body p').html(modalMessage.replace(':tag', $this.data('tag-name')));

                $restoreTagModal.modal('show');
            });

            $restoreTagModal.on('hidden.bs.modal', function () {
                $restoreTagForm.removeAttr('action');
                $restoreTagModal.find('.modal-body p').html('');
            });

            $restoreTagForm.submit(function (event) {
                event.preventDefault();
                var submitBtn = $restoreTagForm.find('button[type="submit"]');
                    submitBtn.button('loading');

                $.ajax({
                    url:      $restoreTagForm.attr('action'),
                    type:     $restoreTagForm.attr('method'),
                    dataType: 'json',
                    data:     $restoreTagForm.serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            $restoreTagModal.modal('hide');
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
        var $deleteTagModal = $('div#deleteTagModal'),
            $deleteTagForm  = $('form#deleteTagForm'),
            deleteTagUrl   = "{{ route('admin::blog.tags.delete', [':id']) }}";

        $('a[href="#deleteTagModal"]').click(function (event) {
            event.preventDefault();

            var $this        = $(this),
                modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this tag : <strong>:tag</strong> ?';

            $deleteTagForm.attr('action', deleteTagUrl.replace(':id', $this.data('tag-id')));
            $deleteTagModal.find('.modal-body p').html(modalMessage.replace(':tag', $this.data('tag-name')));

            $deleteTagModal.modal('show');
        });

        $deleteTagModal.on('hidden.bs.modal', function () {
            $deleteTagForm.removeAttr('action');
            $deleteTagModal.find('.modal-body p').html('');
        });

        $deleteTagForm.submit(function (event) {
            event.preventDefault();
            var submitBtn = $deleteTagForm.find('button[type="submit"]');
                submitBtn.button('loading');

            $.ajax({
                url:      $deleteTagForm.attr('action'),
                type:     $deleteTagForm.attr('method'),
                dataType: 'json',
                data:     $deleteTagForm.serialize(),
                success: function(data) {
                    if (data.status === 'success') {
                        $deleteTagModal.modal('hide');
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
