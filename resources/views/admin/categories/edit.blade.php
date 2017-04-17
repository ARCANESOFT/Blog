<?php /** @var  \Arcanesoft\Blog\Models\Category  $category */ ?>

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
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {{ Form::label('name', trans('blog::categories.attributes.name').' :') }}
                            {{ Form::text('name', old('name', $category->name), ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                                <span class="text-red">{!! $errors->first('name') !!}</span>
                            @endif
                        </div>
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
