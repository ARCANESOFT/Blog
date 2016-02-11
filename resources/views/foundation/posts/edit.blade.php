@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> Posts <small>Edit Post</small></h1>
@endsection

@section('content')
    {{ Form::open(['route' => ['blog::foundation.posts.update', $post->id], 'method' => 'PUT', 'id' => 'updatePostForm', 'class' => 'form form-loading']) }}
    <div class="row">
        <div class="col-md-8 col-lg-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Edit Post</h2>
                </div>
                <div class="box-body">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                        {{ Form::label('title', 'Title :') }}
                        {{ Form::text('title', old('title', $post->title), ['class' => 'form-control']) }}
                        @if ($errors->has('title'))
                            <span class="text-red">{!! $errors->first('title') !!}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : ''}}">
                        {{ Form::label('excerpt', 'Excerpt :') }}
                        {{ Form::textarea('excerpt', old('excerpt', $post->excerpt), ['class' => 'form-control', 'rows' => 1, 'style' => 'resize: none;']) }}
                        @if ($errors->has('excerpt'))
                            <span class="text-red">{!! $errors->first('excerpt') !!}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                        {{ Form::label('content', 'Content :') }}
                        {{ Form::textarea('content', old('content', $post->content), ['class' => 'form-control']) }}
                        @if ($errors->has('content'))
                            <span class="text-red">{!! $errors->first('content') !!}</span>
                        @endif
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('blog::foundation.posts.index') }}" class="btn btn-sm btn-default">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-sm btn-warning pull-right">
                        <i class="fa fa-fw fa-pencil"></i> Update
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="row">
                <div class="col-sm-6 col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-fw fa-bookmark"></i> Category
                            </h3>
                        </div>
                        <div class="box-body">
                            {{ Form::select('category', $categories, old('category', $post->category_id), ['class' => 'form-control', 'data-placeholder' => 'Select a category']) }}
                            @if ($errors->has('category'))
                                <span class="text-red">{!! $errors->first('category') !!}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-fw fa-tags"></i> Tags
                            </h3>
                        </div>
                        <div class="box-body">
                            {{ Form::select('tags[]', $tags, old('tags', $post->tags->lists('id')->toArray()), ['class' => 'form-control', 'multiple' => 'multiple', 'data-placeholder' => 'Select a tag', 'style' => 'width: 100%;']) }}
                            @if ($errors->has('tags'))
                                <span class="text-red">{!! $errors->first('tags') !!}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-fw fa-cog"></i> Extras
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-12">
                                    <div class="form-group {{ $errors->has('publish_date') ? 'has-error' : ''}}">
                                        {{ Form::label('publish_date', 'Publish date (yyyy-mm-dd) :') }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-fw fa-calendar"></i>
                                            </div>
                                            {{ Form::text('publish_date', old('publish_date', $post->publish_date->format('Y-m-d')), ['class' => 'form-control', 'data-date-format' => 'yyyy-mm-dd']) }}
                                        </div>
                                        @if ($errors->has('publish_date'))
                                            <span class="text-red">{!! $errors->first('publish_date') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-12">
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                        {{ Form::label('status', 'Status :') }}
                                        {{ Form::select('status', $statuses, old('status', $post->status), ['class' => 'form-control']) }}
                                        @if ($errors->has('status'))
                                            <span class="text-red">{!! $errors->first('status') !!}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script>
        $(function() {
            CKEDITOR.replace('content');
            $('select[name="tags[]"]').select2();
            $('input#publish_date').datepicker();
        });
    </script>
@endsection
