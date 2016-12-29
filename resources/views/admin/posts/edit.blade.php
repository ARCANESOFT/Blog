@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> Posts <small>Edit Post</small></h1>
@endsection

@section('content')
    {{ Form::open(['route' => ['admin::blog.posts.update', $post], 'method' => 'PUT', 'id' => 'updatePostForm', 'class' => 'form form-loading']) }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Edit Post</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            {{ Form::label('title', 'Title :') }}
                            {{ Form::text('title', old('title', $post->title), ['class' => 'form-control']) }}
                            @if ($errors->has('title'))
                                <span class="text-red">{!! $errors->first('title') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('slug', 'has-error') }}">
                            {{ Form::label('slug', 'Slug :') }}
                            {{ Form::text('slug', old('slug', $post->slug), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="text-red">{!! $errors->first('slug') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-md-4">
                        @include('blog::admin.posts._includes.category-select', ['selectedCategory' => $post->category_id])
                    </div>
                    <div class="col-md-8">
                        @include('blog::admin.posts._includes.tags-select', ['selectedTags' => $post->tags->pluck('id')])
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('excerpt', 'has-error') }}">
                            {{ Form::label('excerpt', 'Excerpt :') }}
                            {{ Form::textarea('excerpt', old('excerpt', $post->excerpt), ['class' => 'form-control', 'rows' => 1, 'style' => 'resize: none;']) }}
                            @if ($errors->has('excerpt'))
                                <span class="text-red">{!! $errors->first('excerpt') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('content', 'has-error') }}">
                            {{ Form::label('content', 'Content :') }}
                            {{ Form::textarea('content', old('content', $post->content), ['class' => 'form-control']) }}
                            @if ($errors->has('content'))
                                <span class="text-red">{!! $errors->first('content') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('publish_date', 'has-error') }}">
                            {{ Form::label('publish_date', 'Publish date (YYYY-MM-DD) :') }}
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></div>
                                {{ Form::text('publish_date', old('publish_date', $post->publish_date->format('Y-m-d')), ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD']) }}
                            </div>
                            @if ($errors->has('publish_date'))
                                <span class="text-red">{!! $errors->first('publish_date') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            {{ Form::label('status', 'Status :') }}
                            {{ Form::select('status', $statuses, old('status', $post->status), ['class' => 'form-control']) }}
                            @if ($errors->has('status'))
                                <span class="text-red">{!! $errors->first('status') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{----------------}}
                    </div>
                </div>
            </div>
        </div>

        @if (view()->exists('seo::admin._composers.seo-form-box'))
            @include('seo::admin._composers.seo-form-box', ['model' => $post])
        @endif

        <div class="box">
            <div class="box-body">
                <a href="{{ route('admin::blog.posts.index') }}" class="btn btn-sm btn-default">
                    Cancel
                </a>
                <button type="submit" class="btn btn-sm btn-warning pull-right">
                    <i class="fa fa-fw fa-pencil"></i> Update
                </button>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('scripts')
    <script>
        $(function() {
            $('textarea[name="content"]').trumbowyg();
            $('input#publish_date').datetimepicker();
        });
    </script>
@endsection
