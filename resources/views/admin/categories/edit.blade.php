<?php /** @var  \Arcanesoft\Blog\Models\Category  $category */ ?>

@inject('blog', 'Arcanesoft\Blog\Blog')

@section('header')
    <h1><i class="fa fa-fw fa-bookmark-o"></i> {{ trans('blog::categories.titles.categories') }} <small>{{ trans('blog::categories.titles.edit-category') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{ Form::open(['route' => ['admin::blog.categories.update', $category], 'method' => 'PUT', 'id' => 'update-category-form', 'class' => 'form form-loading']) }}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title">{{ trans('blog::categories.titles.update-category') }}</h2>
                    </div>
                    <div class="box-body">
                        @if ($blog->isTranslatable())
                            @foreach($blog->getSupportedLocalesKeys() as $locale)
                                <div class="form-group {{ $errors->first("name.$locale", 'has-error') }}">
                                    {{ Form::label("name[$locale]", trans('blog::categories.attributes.name').' ['.strtoupper($locale).']:') }}
                                    {{ Form::text("name[$locale]", old("name[$locale]", $category->getTranslation('name', $locale, false)), ['class' => 'form-control']) }}
                                    @if ($errors->has("name.$locale"))
                                        <span class="text-red">{!! $errors->first("name.$locale") !!}</span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {{ Form::label('name', trans('blog::categories.attributes.name').' :') }}
                                {{ Form::text('name', old('name', $category->name), ['class' => 'form-control']) }}
                                @if ($errors->has('name'))
                                    <span class="text-red">{!! $errors->first('name') !!}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        {{ ui_link('cancel', route('admin::blog.categories.show', [$category])) }}
                        {{ ui_button('update', 'submit')->appendClass('pull-right') }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
