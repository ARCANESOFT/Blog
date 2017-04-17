@section('header')
    <h1><i class="fa fa-fw fa-tags"></i> {{ trans('blog::tags.titles.tags') }} <small>{{ trans('blog::tags.titles.create-tag') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{ Form::open(['route' => 'admin::blog.tags.store', 'method' => 'POST', 'id' => 'create-tag-form', 'class' => 'form form-loading']) }}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title">{{ trans('blog::tags.titles.new-tag') }}</h2>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            {{ Form::label('name', trans('blog::tags.attributes.name').' :') }}
                            {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                                <span class="text-red">{!! $errors->first('name') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ ui_link('cancel', route('admin::blog.tags.index')) }}
                        {{ ui_button('add', 'submit')->appendClass('pull-right') }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
