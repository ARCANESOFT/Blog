@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> {{ trans('blog::posts.titles.posts') }} <small>{{ trans('blog::posts.titles.create-post') }}</small></h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin::blog.posts.store', 'method' => 'POST', 'id' => 'create-post-form', 'class' => 'form form-loading']) }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('blog::posts.titles.new-post') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            {{ Form::label('title', trans('blog::posts.attributes.title').' :') }}
                            {{ Form::text('title', old('title'), ['class' => 'form-control']) }}
                            @if ($errors->has('title'))
                                <span class="text-red">{!! $errors->first('title') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('slug', 'has-error') }}">
                            {{ Form::label('slug', trans('blog::posts.attributes.slug').' :') }}
                            {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="text-red">{!! $errors->first('slug') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-md-4">
                        @include('blog::admin.posts._includes.category-select')
                    </div>
                    <div class="col-md-8">
                        @include('blog::admin.posts._includes.tags-select')
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('excerpt', 'has-error') }}">
                            {{ Form::label('excerpt', trans('blog::posts.attributes.excerpt').' :') }}
                            {{ Form::textarea('excerpt', old('excerpt'), ['class' => 'form-control', 'rows' => 1, 'style' => 'resize: none;']) }}
                            @if ($errors->has('excerpt'))
                                <span class="text-red">{!! $errors->first('excerpt') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('content', 'has-error') }}">
                            {{ Form::label('content', trans('blog::posts.attributes.content').' :') }}
                            {{ Form::textarea('content', old('content'), ['class' => 'form-control']) }}
                            @if ($errors->has('content'))
                                <span class="text-red">{!! $errors->first('content') !!}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            {{ Form::label('status', trans('blog::posts.attributes.status').' :') }}
                            {{ Form::select('status', $statuses, old('status', $statuses->first()), ['class' => 'form-control select-2-fw']) }}
                            @if ($errors->has('status'))
                                <span class="text-red">{!! $errors->first('status') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('published_at', 'has-error') }}">
                            {{ Form::label('published_at', trans('blog::posts.attributes.published_at').' (YYYY-MM-DD) :') }}
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></div>
                                {{ Form::text('published_at', old('published_at', date('Y-m-d')), ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD']) }}
                            </div>
                            @if ($errors->has('published_at'))
                                <span class="text-red">{!! $errors->first('published_at') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{----------------}}
                    </div>
                </div>
            </div>
        </div>

        @includeIf('seo::admin._includes.seo-form-box')

        <div class="box">
            <div class="box-body">
                {{ ui_link('cancel', route('admin::blog.posts.index')) }}
                {{ ui_button('add', 'submit')->appendClass('pull-right') }}
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('scripts')
    <script>
        $(function() {
            new SimpleMDE({
                element: document.getElementById('content')
            });
            $('input[name="published_at"]').datetimepicker();
        });
    </script>
@endsection
