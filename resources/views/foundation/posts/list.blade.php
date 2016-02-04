@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> Posts <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total of posts : {{ $posts->total() }}
            </span>

            @if ($posts->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $posts->currentPage(), 'last' => $posts->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('blog::foundation.posts.index') }}" class="btn btn-xs btn-default {{ route_is('blog::foundation.posts.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> All
                    </a>
                    <a href="{{ route('blog::foundation.posts.trash') }}" class="btn btn-xs btn-default {{ route_is('blog::foundation.posts.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> Trashed
                    </a>
                </div>

                <a href="{{ route('blog::foundation.posts.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Publish date</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-right" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($posts->count())
                            @foreach($posts as $post)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-right">
                                        @include('blog::foundation.posts._partials.table-actions')
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">The list of posts is empty.</span>
                                </td>
                            </tr>
                        @endif
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
