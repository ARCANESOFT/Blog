@inject('blog', 'Arcanesoft\Blog\Blog')

<?php
/**
 * @var  Arcanesoft\Blog\Blog             $blog
 * @var  Arcanesoft\Blog\Models\Tag       $tag
 * @var  Illuminate\Support\ViewErrorBag  $errors
 */
?>

@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> {{ trans('blog::tags.titles.tags') }} <small>{{ trans('blog::tags.titles.edit-tag') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{ form()->open(['route' => ['admin::blog.tags.update', $tag], 'method' => 'PUT', 'id' => 'update-tag-form', 'class' => 'form form-loading']) }}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title">{{ trans('blog::tags.titles.update-tag') }}</h2>
                    </div>
                    <div class="box-body">
                        @if ($blog->isTranslatable())
                            @foreach($blog->getSupportedLocalesKeys() as $locale)
                                <div class="form-group {{ $errors->first("name.$locale", 'has-error') }}">
                                    {{ form()->label("name[$locale]", trans('blog::tags.attributes.name').' ['.strtoupper($locale).']:') }}
                                    {{ form()->text("name[$locale]", old("name[$locale]", $tag->getTranslation('name', $locale, false)), ['class' => 'form-control']) }}
                                    @if ($errors->has("name.$locale"))
                                        <span class="help-block">{{ $errors->first("name.$locale") }}</span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {{ form()->label('name', trans('blog::categories.attributes.name').' :') }}
                                {{ form()->text('name', old('name', $tag->name), ['class' => 'form-control']) }}
                                @if ($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        {{ ui_link('cancel', route('admin::blog.tags.show', [$tag])) }}
                        {{ ui_button('update', 'submit')->appendClass('pull-right') }}
                    </div>
                </div>
            {{ form()->close() }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
