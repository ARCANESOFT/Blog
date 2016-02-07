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
                                        @include('blog::foundation.categories._partials.table-actions')
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
@endsection

@section('scripts')
@endsection
