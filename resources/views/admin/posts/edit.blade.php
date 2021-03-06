@inject('blog', 'Arcanesoft\Blog\Blog')

<?php
/**
 * @var  Arcanesoft\Blog\Blog             $blog
 * @var  Arcanesoft\Blog\Models\Post      $post
 * @var  Illuminate\Support\ViewErrorBag  $errors
 */
?>

@section('header')
    <h1><i class="fa fa-fw fa-files-o"></i> {{ trans('blog::posts.titles.posts') }} <small>{{ trans('blog::posts.titles.edit-post') }}</small></h1>
@endsection

@section('content')
    {{ form()->open(['route' => ['admin::blog.posts.update', $post], 'method' => 'PUT', 'id' => 'update-post-form', 'class' => 'form form-loading']) }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('blog::posts.titles.update-post') }}</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            {{ form()->label('title', trans('blog::posts.attributes.title').' :') }}
                            {{ form()->text('title', old('title', $post->title), ['class' => 'form-control']) }}
                            @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('slug', 'has-error') }}">
                            {{ form()->label('slug', trans('blog::posts.attributes.slug').' :') }}
                            {{ form()->text('slug', old('slug', $post->slug), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="help-block">{{ $errors->first('slug') }}</span>
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
                            {{ form()->label('excerpt', trans('blog::posts.attributes.excerpt').' :') }}
                            {{ form()->textarea('excerpt', old('excerpt', $post->excerpt), ['class' => 'form-control', 'rows' => 2, 'style' => 'resize: none;']) }}
                            @if ($errors->has('excerpt'))
                                <span class="help-block">{{ $errors->first('excerpt') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('thumbnail', 'has-error') }}">
                            {{ form()->label('thumbnail', trans('blog::posts.attributes.thumbnail').' :') }}
                            @if ($blog->isMediaManagerInstalled())
                                <media-browser name="thumbnail" value="{{ old('thumbnail', $post->thumbnail) }}"></media-browser>
                            @else
                                {{ form()->text('thumbnail', old('thumbnail', $post->thumbnail), ['class' => 'form-control']) }}
                            @endif
                            @if ($errors->has('thumbnail'))
                                <span class="help-block">{{ $errors->first('thumbnail') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-xs-12">
                        <div class="form-group {{ $errors->first('content', 'has-error') }}">
                            {{ form()->label('content', trans('blog::posts.attributes.content').' :') }}
                            {{ form()->textarea('content', old('content', $post->content_raw), ['class' => 'form-control']) }}
                            @if ($errors->has('content'))
                                <span class="help-block">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix visible-md visible-lg"></div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('status', 'has-error') }}">
                            {{ form()->label('status', trans('blog::posts.attributes.status').' :') }}
                            {{ form()->select('status', $statuses, old('status', $post->status), ['class' => 'form-control select-2-fw']) }}
                            @if ($errors->has('status'))
                                <span class="help-block">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('published_at', 'has-error') }}">
                            {{ form()->label('published_at', trans('blog::posts.attributes.published_at').' (YYYY-MM-DD) :') }}
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></div>
                                {{ form()->text('published_at', old('published_at', $post->published_at->format('Y-m-d')), ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD']) }}
                            </div>
                            @if ($errors->has('published_at'))
                                <span class="help-block">{{ $errors->first('published_at') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        @includeWhen($blog->isTranslatable(), Arcanesoft\Blog\ViewComposers\Admin\Forms\LocalesSelectComposer::VIEW, ['selectedLocale' => $post->locale])
                    </div>
                </div>
            </div>
        </div>

        @if ($blog->isSeoable())
            @includeIf('seo::admin._includes.seo-form-box', ['model' => $post->seo])
        @endif

        <div class="box">
            <div class="box-body">
                {{ ui_link('cancel', route('admin::blog.posts.show', [$post])) }}
                {{ ui_button('update', 'submit')->appendClass('pull-right') }}
            </div>
        </div>
    {{ form()->close() }}
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
