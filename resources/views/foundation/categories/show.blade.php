@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> Categories <small>{{ $category->name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Category details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
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
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    @can('blog.categories.update')
                    <a href="{{ route('blog::foundation.categories.edit', [$category->id]) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-fw fa-pencil"></i> Update
                    </a>
                    @endcan

                    @can('blog.categories.delete')
                    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteCategoryModal">
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
                            @if ($category->posts->count())
                                @foreach($category->posts as $post)
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

@section('scripts')
@endsection
