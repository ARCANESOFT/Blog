@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> Posts <small>{{ $post->title }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5 col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Details</h2>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <b>Title:</b><br>
                                        {{ $post->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td class="text-right">
                                        <span class="label label-primary">{{ $post->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Author:</th>
                                    <td class="text-right">
                                        <span class="label label-inverse">{{ $post->author->full_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Slug:</b><br>
                                        {{ $post->slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Permalink:</b><br>
                                        {{ route('public::blog.posts.show', [$post->slug]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Excerpt:</b><br>
                                        {{ $post->excerpt }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Tags:</b><br>
                                        @foreach($post->tags as $tag)
                                            <span class="label label-info">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td class="text-right">
                                        <span class="label label-{{ $post->isDraft() ? 'default' : 'success' }}">
                                            {{ $post->status_name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created at:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Updated at:</th>
                                    <td class="text-right">
                                        <small>{{ $post->created_at }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Published at:</th>
                                    <td class="text-right">
                                        <small>{{ $post->published_at }}</small>
                                    </td>
                                </tr>
                                @if ($post->trashed())
                                <tr>
                                    <th>Deleted at:</th>
                                    <td class="text-right">
                                        <small>{{ $post->deleted_at }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <a href="{{ route('admin::blog.posts.edit', [$post]) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-fw fa-pencil"></i> Edit
                    </a>
                    <a href="#deletePostModal" class="btn btn-sm btn-danger">
                        <i class="fa fa-fw fa-trash-o"></i> Delete
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-8">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">Content</h2>
                    <div class="box-tools">
                        <ul class="nav nav-pills nav-sm" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#content_html" aria-controls="content_html" role="tab" data-toggle="tab">HTML</a>
                            </li>
                            <li role="presentation">
                                <a href="#content_raw" aria-controls="content_raw" role="tab" data-toggle="tab">RAW</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="content_html">
                            {{ $post->content }}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="content_raw">
                            <pre>{{ $post->content_raw }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
